@extends('translation::layout')

@section('body')

    <form action="{{ route('languages.translations.index', ['language' => $language]) }}" method="get">

        <div class="panel">

            <div class="panel-header">

                {{ __('translation::translation.translations') }}

                <div class="flex flex-grow justify-end items-center">

                    @include('translation::forms.search', ['name' => 'filter', 'value' => Request::get('filter')])

                    @include('translation::forms.select', ['name' => 'language', 'items' => $languages, 'submit' => true, 'selected' => $language])

                    <div class="sm:hidden lg:flex items-center">

                        @include('translation::forms.select', ['name' => 'group', 'items' => $groups, 'submit' => true, 'selected' => Request::get('group'), 'optional' => true])

                        <a href="{{ route('languages.translations.create', $language) }}" class="button">
                            {{ __('translation::translation.add') }}
                        </a>

                    </div>

                </div>

            </div>

            <div class="panel-body">

                @if(count($translations))

                    <table id="translationsTable">
                        <thead>
                        <tr>
                            <th class="w-1/5 uppercase font-thin">{{ __('translation::translation.group_single') }}</th>
                            <th class="w-1/5 uppercase font-thin">{{ __('translation::translation.key') }}</th>
                            <th class="uppercase font-thin">{{ config('app.locale') }}</th>
                            <th class="uppercase font-thin">{{ $language }}</th>
                        </tr>
                        </thead>
                        <tbody id="translationsBody">
                        {{--                        @foreach($translations as $type => $items)--}}

                        {{--                            @foreach($items as $group => $translations)--}}
                        {{--                                @foreach($translations as $key => $value)--}}

                        {{--                                    @if(!is_array($value['ar']))--}}
                        {{--                                        <tr>--}}
                        {{--                                            <td>{{ $group }}</td>--}}
                        {{--                                            <!-- I don't know why crash with following two lines and with ar.json & en.json files -->--}}
                        {{--                                            <td>{{ $key }}</td>--}}
                        {{--                                            <td>{{ $value['ar'] }}</td>--}}
                        {{--                                            <td>--}}
                        {{--                                                <translation-input--}}
                        {{--                                                        initial-translation="{{ $value[$language] }}"--}}
                        {{--                                                        language="{{ $language }}"--}}
                        {{--                                                        group="{{ $group }}"--}}
                        {{--                                                        translation-key="{{ $key }}"--}}
                        {{--                                                        route="{{ config('translation.ui_url') }}">--}}
                        {{--                                                </translation-input>--}}
                        {{--                                            </td>--}}
                        {{--                                        </tr>--}}
                        {{--                                    @endif--}}
                        {{--                                @endforeach--}}
                        <!-- Rows will be dynamically inserted here -->
                        </tbody>
                    </table>

                @endif

            </div>

        </div>

    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const language = @json($language);
            const route = @json(config('translation.ui_url'));
            const translations = @json($translations);

            const tableBody = document.getElementById('translationsBody');

            Object.keys(translations).forEach(type => {
                const items = translations[type];

                Object.keys(items).forEach(group => {
                    const translations = items[group];

                    Object.keys(translations).forEach(key => {

                        const value = translations[key];
                        const initialTranslation = value[language] || '';


                        // if (typeof value['ar'] !== 'string') {
                        //     console.warn('Skipping invalid translation entry:', key, value);
                        //     return;
                        // }

                        const row = document.createElement('tr');

                        const cellGroup = document.createElement('td');
                        cellGroup.textContent = group;

                        const cellKey = document.createElement('td');
                        cellKey.textContent = key;

                        const cellValue = document.createElement('td');
                        cellValue.textContent = value['ar'];

                        const cellEditing = document.createElement('td');
                        const translationComponent = document.createElement('translation-input');

                        translationComponent.setAttribute('initial-translation', initialTranslation);
                        translationComponent.setAttribute('language', language);
                        translationComponent.setAttribute('group', group);
                        translationComponent.setAttribute('translation-key', key);
                        translationComponent.setAttribute('route', route);

                        cellEditing.appendChild(translationComponent);

                        row.appendChild(cellGroup);
                        row.appendChild(cellKey);
                        row.appendChild(cellValue);
                        row.appendChild(cellEditing);

                        tableBody.appendChild(row);

                        // Re-initialize Vue for the dynamically added component
                        new Vue({
                            el: translationComponent
                        });
                    });
                });
            });
        });
    </script>

@endsection
