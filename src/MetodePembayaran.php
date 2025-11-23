<?php

function pilihMetodePembayaran($metode): string {
    return "Metode pembayaran $metode berhasil dipilih";
}

function pembayaranKartuKredit($nama, $nomorKartu, $cvv): string {
    if (preg_match(pattern: '/^[0-9]{16}$/', subject: $nomorKartu) && preg_match(pattern: '/^[0-9]{3}$/', subject: $cvv)) {
        return "Transaksi dengan kartu kredit atas nama $nama berhasil";
    } else {
        return "Nomor kartu kredit atau CVV tidak valid";
    }
}

function pembayaranTransferBank($bank, $nomorRekening): string{
    if (!empty($bank) && preg_match(pattern: '/^[0-9]{10,}$/', subject: $nomorRekening)){
        return "Transaksi transfer bank ke $bank dengan rekening $nomorRekening berhasil";
    } else {
        return "Data transfer bank tidak valid";
    }
}
?>