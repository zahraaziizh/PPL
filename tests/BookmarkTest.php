<?php
use PHPUnit\Framework\TestCase;
require __DIR__ . '/../src/Bookmark.php';

class BookmarkTest extends TestCase
{
    //TC31 - Menekan ikon saved dari item yang ingin di bookmark
    public function testBookmarkItem()
    {
        $bookmarks = [];
        $bookmarks = bookmarkItem("Hotel Tjokro Jakarta", $bookmarks);
        $this->assertContains("Hotel Tjokro Jakarta", $bookmarks);
    }
    //TC32 - Menekan kembali ikon saved dari item yang sudah di bookmark
    public function testUnbookmarkItem()
    {
        $bookmarks = ["Hotel Tjokro Jakarta"];
        $bookmarks = unbookmarkItem("Hotel Tjokro Jakarta", $bookmarks);
        $this->assertNotContains("Hotel Tjokro Jakarta", $bookmarks);
    }
    //TC33 - menekan titik tiga pada koleksi, edit colection, dan setting publisitas
    public function testUbahPublisitasKoleksi()
    {
        $koleksi = ["nama" => "Hotel Favorit", "publik" => false];
        $hasil = ubahPublisitasKoleksi($koleksi, true);
        $this->assertTrue($hasil['publik']);
    }
    //TC34 - Menekan ikon saved dari item di bookmark
    public function testAksesItemDiBookmark()
    {
        $bookmarks = ["Hotel Favehotel PGC Cililitan"];
        $exists = aksesItemDiBookmark("Hotel Favehotel PGC Cililitan", $bookmarks);
        $this->assertTrue($exists);
    }
    //TC35 - Memfilter bookmark
    public function testFilterBookmark()
    {
        $bookmarks = ["Hotel Tjokro Jakarta", "Hotel Solo Indah"];
        $filtered = filterBookmark("solo", $bookmarks);
        $this->assertCount(1, $filtered);
        $this->assertContains("Hotel Solo Indah", $filtered);
    }
    //TC36 - mengkategorikan koleksi
    public function testBuatKoleksi()
    {
        $koleksi = buatKoleksi("Solo");
        $this->assertEquals("Solo", $koleksi['nama']);
        $this->assertFalse($koleksi['publik']);
        $this->assertIsArray($koleksi['items']);
    }
}
