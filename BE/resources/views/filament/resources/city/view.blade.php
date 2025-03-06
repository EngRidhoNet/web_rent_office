<div class="space-y-6">
    <div class="filament-infolists-section-component space-y-2">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold tracking-tight">Detail Kota</h3>
        </div>

        <div class="filament-infolists-text-entry grid grid-cols-1 gap-4 p-4 bg-white rounded-xl border border-gray-300">
            <div>
                <div class="flex flex-col space-y-1">
                    <span class="text-sm font-medium text-gray-600">Nama Kota</span>
                    <div class="text-lg">{{ $record->name }}</div>
                </div>
            </div>
        </div>

        <div class="filament-infolists-image-entry grid grid-cols-1 gap-4 p-4 bg-white rounded-xl border border-gray-300">
            <div>
                <div class="flex flex-col space-y-1">
                    <span class="text-sm font-medium text-gray-600">Foto Kota</span>
                    <div class="mt-2">
                        @if($record->photo)
                            <img src="{{ $imageUrl }}" alt="{{ $record->name }}" class="rounded-lg shadow-md max-w-full h-auto" style="max-height: 300px;">
                        @else
                            <div class="rounded bg-gray-200 text-gray-500 flex items-center justify-center" style="width: 300px; height: 168px;">
                                Tidak ada foto
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="filament-infolists-text-entry grid grid-cols-1 gap-4 p-4 bg-white rounded-xl border border-gray-300">
            <div>
                <div class="flex flex-col space-y-1">
                    <span class="text-sm font-medium text-gray-600">Terakhir Diperbarui</span>
                    <div class="text-lg">{{ $record->updated_at->format('d M Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
