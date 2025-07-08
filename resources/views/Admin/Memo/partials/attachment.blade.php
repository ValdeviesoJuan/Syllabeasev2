@php
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $icon = match(strtolower($ext)) {
        'pdf' => 'mdi:file-pdf-box',
        'doc', 'docx' => 'mdi:file-word-box',
        'xls', 'xlsx' => 'mdi:file-excel-box',
        'jpg', 'jpeg', 'png' => 'mdi:file-image',
        default => 'mdi:file-document-outline',
    };

    $iconColor = match(strtolower($ext)) {
        'pdf' => '#DC2626',
        'doc', 'docx' => '#1D4ED8',
        'xls', 'xlsx' => '#15803D',
        'jpg', 'jpeg', 'png' => '#CA8A04',
        default => '#2563EB',
    };
@endphp

<div class="flex items-center gap-4 border rounded-lg p-4 shadow-md max-w-lg transition duration-200"
     style="background-color: #E8F1FF; border-color: #B3D4FC;"
     onmouseover="this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.15)'; this.style.transform='translateY(-2px)'"
     onmouseout="this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1)'; this.style.transform='none'">
    
    <div class="flex-shrink-0">
        <iconify-icon icon="{{ $icon }}" width="40" height="40" style="color: {{ $iconColor }}"></iconify-icon>
    </div>

    <div class="flex-1 overflow-hidden">
        <p class="text-sm font-semibold truncate" style="color: #1E3A8A;">
            {{ $file }}
        </p>
        <a href="{{ route('admin.downloadMemo', ['id' => $memo->id, 'filename' => $file]) }}"
           class="text-sm flex items-center gap-1 mt-1 hover:underline"
           style="color: #2563EB;">
            <iconify-icon icon="mdi:download" width="16" height="16"></iconify-icon>
            Download Attachment
        </a>
    </div>
</div>
