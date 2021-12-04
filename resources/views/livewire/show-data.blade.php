<div class="p-5">
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table wire:poll="readRawFile" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Timestamp
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Priority
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                GPS DATA
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                IO DATA
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($decodedData as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 max-w-screen-lg overflow-hidden">
                                    {{ $item["timestamp"] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 max-w-screen-lg overflow-hidden">
                                    {{ $item["priority"] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 max-w-screen-lg overflow-hidden">
                                    {{ $item["gps_data"]['latitude'] }}, {{ $item["gps_data"]['longitude'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 max-w-screen-lg overflow-hidden">
                                    {{ implode(', ', array_map(fn ($x) => array_keys($x)[0] . ":" . $x[array_keys($x)[0]], $item["io_data"])) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col mt-5">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Data
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Decode</span>
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">DecodeAndSave</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($rawData as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 max-w-screen-lg overflow-hidden">
                                {{ $item }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a wire:click="decode({{ $loop->index }})" href="#" class="text-indigo-600 hover:text-indigo-900">Decode</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a wire:click="decodeAndSave({{ $loop->index }})" href="#" class="text-indigo-600 hover:text-indigo-900">DecodeAndSave</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
