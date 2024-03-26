<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<style>
    .bg-teal-100 {
        background-color: #D1FAE5;
    }

    .hover\:bg-teal-100:hover {
        background-color: #D1FAE5;
    }

    .text-teal-400 {
        color: #34D399;
    }

    .hover\:text-teal-400:hover {
        color: #34D399;
    }

    .border-teal-100 {
        border-color: #D1FAE5;
    }

    .hover\:border-teal-100:hover {
        border-color: #D1FAE5;
    }
</style>
</head>

<body>
    <div class="w-full md:w-1/2 flex flex-col items-center h-64 mx-auto">
        <div class="w-full px-4">
            <div class="relative">
                <div class="my-2 p-1 flex border border-gray-200 bg-white rounded">
                    <div class="flex flex-auto flex-wrap">
                        <div class="flex-1">
                            <input
                                id="selectedItemInput"
                                class="bg-transparent p-1 px-2 outline-none w-full text-gray-800 min-w-80 max-w-150 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block font-medium text-sm" />
                        </div>
                        <div
                            id="selectedItems"
                            class="flex flex-wrap"
                        >
                        </div>
                        <button id="toggleButton" class="text-teal-400 hover:text-teal-400">
                            <svg
                                id="icon-up"
                                class="h-5 w-5 text-gray-500"
                                width="100%"
                                height="100%"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                                stroke="currentColor"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                            <svg
                                id="icon-down"
                                class="h-5 w-5 text-gray-500 hidden"
                                width="100%"
                                height="100%"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <polyline points="18 15 12 9 6 15" />
                            </svg>
                        </button>
                    </div>
                    <div id="optionsMenu"
                        class="menu-dropdown absolute shadow top-full bg-white z-40 w-full left-0 rounded overflow-y-auto hidden max-h-select">
                        <div class="flex flex-col w-full" id="optionsList"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const selectedItemInput = document.getElementById('selectedItemInput');
        const selectedItemsContainer = document.getElementById('selectedItems');
        const optionsMenu = document.getElementById('optionsMenu');
        const optionsList = document.getElementById('optionsList');
        const toggleButton = document.getElementById('toggleButton');
        let items = {!! json_encode($items) !!};
        let selectedItems = [];
        let showOptions = {{ $showOptions ? 'true' : 'false' }};
        const iconUp = document.getElementById('icon-up');
        const iconDown = document.getElementById('icon-down');
        const isMultiSelect = {{ $multiselect ? 'true' : 'false' }};

        function selectItem(itemName) {
            if (isMultiSelect) {
                selectedItems.push(itemName);
                updateSelectedItems();
            } else {
                selectedItemInput.value = itemName;
                toggleShowOptions();
            }
            updateOptionsList();
        }

        function updateSelectedItems() {
            if (isMultiSelect) {
                selectedItemsContainer.innerHTML = selectedItems.map(item => {
                    return `
                        <div class="flex items-center bg-teal-200 text-teal-800 rounded-full px-3 py-1 m-1">
                            <span>${item}</span>
                            <button type="button" class="ml-2" onclick="removeSelectedItem('${item}')">&times;</button>
                        </div>`;
                }).join('');
                selectedItemInput.value = '';
            }
        }

        function removeSelectedItem(itemName) {
            if (isMultiSelect) {
                selectedItems = selectedItems.filter(item => item !== itemName);
                updateSelectedItems();
            }
            updateOptionsList();
        }

        function toggleShowOptions() {
            showOptions = !showOptions;
            optionsMenu.classList.toggle('hidden', !showOptions);
            iconUp.classList.toggle('hidden', showOptions);
            iconDown.classList.toggle('hidden', !showOptions);
        }

        function filterItems(searchTerm) {
            const filteredItems = items.filter(item => item.name.toLowerCase().includes(searchTerm.toLowerCase()));
            updateOptionsList(filteredItems);
        }

        function updateOptionsList(filteredItems = items) {
            optionsList.innerHTML = filteredItems.map(item => {
                if (!selectedItems.includes(item.name)) {
                    return `
                        <div class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-teal-100" onclick="selectItem('${item.name}')">
                            <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                                <div class="w-auto items-center flex">
                                    <div class="mx-2 leading-6">${item.name}</div>
                                </div>
                            </div>
                        </div>`;
                }
            }).join('');
        }

        updateOptionsList();
        selectedItemInput.addEventListener('input', event => filterItems(event.target.value));
        toggleButton.addEventListener('click', toggleShowOptions);
    </script>
</body>

</html>
