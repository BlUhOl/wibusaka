<x-app-layout>
    <x-slot name="title">{{ $anime['title'] }}</x-slot>
    <x-slot name="meta_description">{{(!empty($anime['synopsis'])) ? __('meta.single.description', ['synopsis' => \Str::words($anime['synopsis'], 30), 'anime' => $anime['title']]) : __('meta.single.description_empty') }}</x-slot>
    <x-slot name="meta_robots">noindex, nofollow</x-slot>

    <div class="flex flex-col py-4 md:flex-row">
        <div class="grid justify-between flex-none w-full grid-cols-2 md:grid-cols-1 md:items-center md:w-72 md:h-full">
            <div class="w-full text-center">
                <div class="relative mx-auto rounded-lg anime-cover">
                    <div class="flex flex-col items-center justify-center w-full h-96 spinner">
                        <x-icons.spinner class="block w-5 h-5" />
                    </div>
                    <img data-src="{{ $anime['image_url'] }}" alt="'{{ $anime['title'] }}' Anime Poster" class="absolute inset-x-0 top-0 w-full mx-auto opacity-0" />
                </div>
                <div class="grid w-auto grid-cols-2 py-2 my-3 bg-gray-100 rounded-xl dark:bg-green-800 dark:bg-opacity-50">
                    <div class="text-center font-primary">
                        <span class="text-lg font-semibold md:text-2xl">
                            <x-icons.star-solid class="inline-block w-3 h-3 md:w-5 md:h-5" />
                            {{ !empty($anime['score']) ? number_format($anime['score'], 2, '.', '') : 'N/A' }}
                        </span>
                        <p class="text-sm md:text-md">{{ __('anime.single.score') }}</p>
                    </div>
                    <div class="text-center font-primary">
                        <p class="text-lg font-semibold md:text-2xl">#{{ $anime['popularity'] }}</p>
                        <p class="text-sm md:text-md">{{ __('anime.single.popularity') }}</p>
                    </div>
                    <div class="text-center font-primary">
                        <p class="text-lg font-semibold md:text-2xl">{{ $anime['members'] }}</p>
                        <p class="hidden text-sm md:block">{{ __('anime.single.members') }}</p>
                        <p class="text-sm md:hidden">{{ __('anime.single.members_mobile') }}</p>
                    </div>
                    <div class="text-center">
                        <div class="flex flex-row items-center justify-center md:gap-1">
                            <p class="text-lg font-semibold font-primary md:text-2xl">{{ $anime['rating'] ?? 'N/A' }}</p>
                            @if ($anime['rating'] != 'None')
                            <div class="relative flex flex-col items-center group">
                                @if (in_array($anime['rating'], ['R', 'R+', 'Rx']))
                                <x-icons.exclamation-solid class="hidden w-5 h-5 md:block" />
                                @else
                                <x-icons.information-circle-solid class="hidden w-4 h-4 md:block" />
                                @endif
                                <div class="absolute bottom-0 flex-col items-center hidden w-48 mb-6 group-hover:flex">
                                    <div class="relative z-20 p-2 text-sm leading-4 text-white whitespace-no-wrap bg-black shadow-xl rounded-xl">
                                        {{ __('anime.single.rating_note.' . $anime['rating']) }}
                                    </div>
                                    <div class="w-3 h-3 -mt-2 transform rotate-45 bg-black"></div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <p class="text-sm font-primary md:text-md">{{ __('anime.single.rating') }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-2 md:grid-flow-col md:auto-cols-fr">
                    <x-button-link href="{{ $anime['url'] }}" target="_blank" class="h-16">
                        <p class="mr-2 text-lg text-left">MAL</p>
                    </x-button-link>
                    @if (isset($anime['external_links']['Website']))
                    <x-button-link href="{{ $anime['external_links']['Website'] }}" target="_blank" class="h-16">
                        <p class="mr-2 text-lg text-left">Website</p>
                    </x-button-link>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-1 gap-2 pt-2 pl-2 border-gray-400 border-opacity-50 border-dashed md:mt-3 md:border-t">
                <div class="border-b border-gray-400 border-opacity-50 border-dashed md:hidden">
                    <h2 class="text-lg font-bold text-green-700 font-primary dark:text-green-300">{{ $anime['title'] }}</h2>
                    <p class="text-sm italic">{{ $anime['title_english'] }}</p>
                    <p class="text-sm italic">{{ $anime['title_japanese'] }}</p>
                </div>
                <div class="hidden md:block">
                    <p class="text-lg font-semibold font-primary">{{ __('anime.single.alternative_title') }}</p>
                    <p class="text-sm md:text-md">{{ (count($anime['title_synonyms']) > 0) ? implode(', ', $anime['title_synonyms']) : '-' }}</p>
                </div>
                <div>
                    <p class="font-semibold font-primary md:text-lg">{{ __('anime.single.type') }}</p>
                    <p class="text-sm md:text-md">
                        {{ $anime['type'] }}
                        @if ($anime['episodes'] > 1) <span class="text-xs">({{ $anime['episodes'] }} ep)</span> @endif
                        @if (!empty($anime['duration'])) <span class="text-xs">({{ $anime['duration'] }})</span> @endif
                    </p>
                </div>
                <div>
                    <p class="font-semibold font-primary md:text-lg">{{ __('anime.single.status') }}</p>
                    <p class="text-sm md:text-md">{{ $anime['status'] }}</p>
                </div>
                <div>
                    <p class="font-semibold font-primary md:text-lg">{{ __('anime.single.airing_date') }}</p>
                    <p class="text-sm md:text-md">{{ $anime['aired']['from'] }}@if ($anime['episodes'] > 1 || $anime['airing']) s.d {{ $anime['aired']['to'] }}@endif</p>
                    <p class="text-xs">
                        @if (!empty($anime['premiered']))
                        <a href="{{ route('anime.season', ['year' => $anime['premiered']['year'], 'season' => $anime['premiered']['season']]) }}" class="text-link">({{ $anime['premiered']['full'] }})</a>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="font-semibold font-primary md:text-lg">{{ __('anime.single.studio') }}</p>
                    <p class="text-sm md:text-md">
                        {{ $anime['studios']->implode('name', ', ') }}
                    </p>
                </div>
                <div>
                    <p class="font-semibold font-primary md:text-lg">{{ __('anime.single.source') }}</p>
                    <p class="text-sm md:text-md">{{ $anime['source'] }}</p>
                </div>
                <div>
                    <div class="font-semibold font-primary md:text-lg">{{ __('anime.single.genre') }}</div>
                    <p class="text-sm md:text-md">
                        @forelse ($anime['genres'] as $genre)
                            <a href="{{ route('anime.genre.show', ['slug' => str_replace(' ', '-', strtolower($genre['name']))]) }}" class="text-link">{{ $genre['name'] }}</a>{{ (!$loop->last) ? ',' : '' }}
                        @empty
                            <span>-</span>
                        @endforelse
                    </p>
                </div>
                <div>
                    <div class="font-semibold font-primary md:text-lg">{{ __('anime.single.demographic') }}</div>
                    <p class="text-sm md:text-md">
                        @forelse ($anime['demographics'] as $demo)
                            <a href="{{ route('anime.genre.show', ['slug' => str_replace(' ', '-', strtolower($demo['name']))]) }}" class="text-link">{{ $demo['name'] }}</a>{{ (!$loop->last) ? ',' : '' }}
                        @empty
                            <span>-</span>
                        @endforelse
                    </p>
                </div>
                <div>
                    <p class="font-semibold font-primary md:text-lg">{{ __('anime.single.external_link') }}</p>
                    <div class="flex flex-col gap-1 text-sm md:text-md">
                        @forelse ($anime['external_links'] as $name => $url)
                            @if ($name == 'Website') @continue @endif
                            <a href="{{ $url }}" class="text-link">{{ $name }} <x-icons.external-link-solid class="inline-block w-4 h-4 ml-1" /></a>
                        @empty
                            <span>-</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        @if ($anime['rating'] != 'None' && in_array($anime['rating'], ['R', 'R+', 'Rx']))
        <div class="flex flex-col items-center w-auto gap-2 p-2 my-4 bg-gray-200 md:hidden rounded-xl dark:bg-gray-800">
            <x-icons.exclamation-solid class="w-8 h-8" />
            <p class="text-sm text-center">{{ __('anime.single.rating_note.' . $anime['rating']) }}</p>
        </div>
        @endif

        <div class="flex-grow md:ml-12">
            <h2 class="hidden text-3xl font-bold text-left text-green-700 dark:text-green-300 font-primary md:block lg:text-5xl">{{ $anime['title'] }}</h2>
            <p class="hidden pt-2 text-sm italic text-left md:block">{{ $anime['title_english'] }} / {{ $anime['title_japanese'] }}</p>

            <h3 class="py-3 text-2xl font-semibold border-b border-gray-400 border-opacity-50 border-dashed font-primary">{{ __('anime.single.synopsis') }}</h3>
            <div class="mt-3">
                @if (!empty($anime['synopsis'])) {{ $anime['synopsis'] }} @else <i>{{ __('anime.single.synopsis_empty') }}</i> @endif
            </div>

            @if (!empty($anime['related']))
            <h3 class="py-3 text-2xl font-semibold border-b border-gray-400 border-opacity-50 border-dashed font-primary">{{ __('anime.single.related') }}</h3>
            <table class="w-full mt-4 table-fixed">
                <thead>
                    <tr>
                        <th class="w-1/4 lg:w-1/6"></th>
                        <th class="w-auto"></th>
                        <th class="w-3/4 lg:w-5/6"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($anime['related'] as $key => $relate)
                    <tr class="border-b border-gray-400 border-dashed border-opacity-30">
                        <td class="font-semibold align-top">
                            {{ __('anime.single.relations.' . \Str::slug($key, '_')) }}
                        </td>
                        <td class="align-top">:</td>
                        <td class="pl-2 align-top">
                        @foreach ($relate as $mal)
                            <a href="{{ ($mal['type'] == 'anime') ? route('anime.show', ['id' => $mal['mal_id']]) : $mal['url'] }}" class="text-link">
                                {{ $mal['name'] }}
                                @if ($key == 'Adaptation')
                                <x-icons.external-link-solid class="inline-block w-4 h-4" />
                                @endif
                            </a>{{ (!$loop->last) ? ', ' : '' }}
                        @endforeach
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            @if ($anime['status'] != 'Belum Tayang')
            <div class="flex flex-col mt-4">
                <h3 class="pb-3 text-2xl font-semibold border-b border-gray-400 border-opacity-50 border-dashed font-primary">{{ __('anime.single.availability') }}</h3>
                <livewire:availability-grid :mal="$anime['mal_id']" />
                <div class="flex items-center h-12 col-span-3 m-2">
                    <p class="w-full text-center text-sm text-gray-700 dark:text-gray-300">Bantu kami menemukan lebih banyak platform untuk menonton anime ini melalui
                        <a href="{{ config('anime.link.discord') }}" target="_blank" class="font-semibold text-link">
                            Discord kami!<x-icons.discord class="inline-flex w-6 h-6 pl-2" fill="currentColor" />
                        </a>
                    </p>
                </div>
            </div>
            @endif

            @if (count($anime['opening_themes']) > 0 && count($anime['ending_themes']) > 0)
            <h3 class="py-3 text-2xl font-semibold border-b border-gray-400 border-opacity-50 border-dashed font-primary">{{ __('anime.single.theme_song') }}</h3>
            <div class="grid justify-between grid-cols-1 md:grid-cols-2">
                <div class="mt-3">
                    <h4 class="text-lg font-semibold">{{ __('anime.single.theme_song_op') }}</h4>
                    <p class="mt-1">
                        {!! implode('<br />', $anime['opening_themes']) !!}
                    </p>
                </div>
                <div class="mt-3">
                    <h4 class="text-lg font-semibold">{{ __('anime.single.theme_song_ed') }}</h4>
                    <p class="mt-1">
                        {!! implode('<br />', $anime['ending_themes']) !!}
                    </p>
                </div>
            </div>
            @endif

            @if ($anime['status'] != 'Belum Tayang')
            <div class="flex flex-col mt-4">
                <h3 class="py-3 text-2xl font-semibold border-b border-gray-400 border-opacity-50 border-dashed font-primary">{{ __('anime.single.recommendation') }}</h3>
                <livewire:recommendation-list :mal="$anime['mal_id']" />
            </div>
            @endif
        </div>
    </div>
</x-app-layout>