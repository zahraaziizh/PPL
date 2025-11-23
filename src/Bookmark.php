<?php
//TC31 - Menekan ikon saved dari item yang ingin di bookmark
function bookmarkItem($item, &$bookmarks){
    $bookmarks[] = $item;
    return $bookmarks;
}
//TC32 - Menekan kembali ikon saved dari item yang sudah di bookmark
function unbookmarkItem($item, &$bookmarks){
    $bookmarks = array_filter($bookmarks, function($b) use ($item){
        return $b !== $item;
    });
    return array_values($bookmarks);
}
//TC33 - menekan titik tiga pada koleksi, edit colection, dan setting publisitas
function ubahPublisitasKoleksi(&$koleksi, $status){
    $koleksi['publik'] = $status;
    return $koleksi;
}
//TC34 - Menekan ikon saved dari item di bookmark
function aksesItemDiBookmark($item, $bookmarks){
    return in_array($item, $bookmarks);
}
//TC35 - Memfilter bookmark
function filterBookmark($kota, $bookmarks){
    return array_filter($bookmarks, function($b) use ($kota){
        return stripos($b, $kota) !== false;
    });
}
//TC36 - mengkategorikan koleksi
function buatKoleksi($nama){
    return[
        "nama" => $nama,
        "items" => [],
        "publik" => false
    ];
}
