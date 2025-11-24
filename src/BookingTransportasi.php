<?php
//INTEGRASI TESTING - TC03

//TC07 - Mengisi waktu,asal, tujuan, dan jumlah kursi 
//TC08 - Mengisi waktu,asal, tujuan, dan jumlah kursi di waktu hari ini  
function bookingTransportasi($asal, $tujuan, $waktu, $kursi){
    if (empty($asal) || empty($tujuan) || empty($waktu) || $kursi <= 0) {
       return false;
    }
    return[
        "asal" => $asal,
        "tujuan" => $tujuan,
        "waktu" => $waktu,
        "kursi" => $kursi
    ];
}
//TC09 - Menfilter pilihan tiket berdasarkan kategori
//TC10 - Menfilter pilihan tiket berdasarkan kategori namun tidak ada tiket yang sesuai dengan filter
function filterTiket($kategori, $waktuRange, $tiketTersedia){
    $hasil = array_filter($tiketTersedia, function($tiket) use ($kategori, $waktuRange){
        return $tiket['kategori'] === $kategori && $tiket['time'] === $waktuRange;
    });
    return array_values($hasil);
}
//TC11 - Memilih tiket yang ingin dibooking
function pilihTiket($tiketId, $tiketTersedia){
    foreach ($tiketTersedia as $tiket){
        if ($tiket['id'] === $tiketId){
            return $tiket;
        }
    }
    return null;
}
