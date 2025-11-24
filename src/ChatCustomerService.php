<?php

function pilihPusatBantuan(): string {
    return "Opsi pusat bantuan berhasil dipilih";
}

function chatDenganCS($hasOrder): string {
    if($hasOrder) {
        return "Chat dengan cs terkait pesanan Anda dimulai";
    } else {
        return "Chat dengan CS umum dimulai (tidak ada pesanan)";
    }
}
?>