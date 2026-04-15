<x-layouts.marketplace>

    <div class="kategori-header text-center py-5">
        @if($kategori == 'reguler-9-hari')
        <h1>Paket Umroh Reguler 9 Hari</h1>
        <p>Pilihan tepat untuk ibadah yang efisien dan nyaman.</p>

        @elseif($kategori == 'umroh-plus-wisata')
        <h1>Paket Umroh Plus Wisata Halal</h1>
        <p>Ibadah umroh sekaligus tadabbur alam ke berbagai negara.</p>

        @elseif($kategori == 'haji-khusus')
        <h1>Program Haji Khusus (ONH Plus)</h1>
        <p>Berangkat haji lebih cepat tanpa antrean puluhan tahun.</p>

        @else
        <h1>Katalog Produk Kami</h1>
        <p>Pilih paket ibadah yang sesuai dengan kebutuhan Anda.</p>
        @endif
    </div>

    <div class="row">
        @if($kategori == 'haji-khusus')
        @elseif($kategori == 'reguler-9-hari')
        @endif
    </div>

</x-layouts.marketplace>