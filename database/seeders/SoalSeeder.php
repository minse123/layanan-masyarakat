<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\KategoriSoalPelatihan;

class SoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriBumdes = KategoriSoalPelatihan::where('nama_kategori', 'Bumdes')->first();
        $kategoriKPMD = KategoriSoalPelatihan::where('nama_kategori', 'KPMD')->first();
        $kategoriMasyarakatHukumAdat = KategoriSoalPelatihan::where('nama_kategori', 'Masyarakat Hukum Adat')->first();
        $kategoriPembangunanDesaWisata = KategoriSoalPelatihan::where('nama_kategori', 'Pembangunan Desa Wisata')->first();
        $kategoriCatrans = KategoriSoalPelatihan::where('nama_kategori', 'Catrans')->first();
        $kategoriPelatihanPerencanaan = KategoriSoalPelatihan::where('nama_kategori', 'Pelatihan Perencanaan Pembangunan Partisipatif')->first();
        $kategoriPrukades = KategoriSoalPelatihan::where('nama_kategori', 'Prukades')->first();
        $kategoriPrudes = KategoriSoalPelatihan::where('nama_kategori', 'Prudes')->first();
        $kategoriEcomerce = KategoriSoalPelatihan::where('nama_kategori', 'Ecomerce')->first();

        $soalData = [];

        if ($kategoriBumdes) {
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriBumdes->id,
                'pertanyaan' => 'Apa kepanjangan dari BUMDes?',
                'pilihan_a' => 'Badan Usaha Milik Desa',
                'pilihan_b' => 'Badan Usaha Mandiri Desa',
                'pilihan_c' => 'Badan Usaha Masyarakat Desa',
                'pilihan_d' => 'Badan Usaha Bersama Desa',
                'jawaban_benar' => 'a',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriBumdes->id,
                'pertanyaan' => 'Siapa yang bertanggung jawab atas pengelolaan BUMDes?',
                'pilihan_a' => 'Kepala Desa',
                'pilihan_b' => 'Direktur BUMDes',
                'pilihan_c' => 'Sekretaris Desa',
                'pilihan_d' => 'Bendahara Desa',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriBumdes->id,
                'pertanyaan' => 'Apa tujuan utama pendirian BUMDes?',
                'pilihan_a' => 'Meningkatkan pendapatan asli desa',
                'pilihan_b' => 'Membantu pemerintah pusat',
                'pilihan_c' => 'Mengurangi jumlah penduduk miskin',
                'pilihan_d' => 'Membangun infrastruktur desa',
                'jawaban_benar' => 'a',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriBumdes->id,
                'pertanyaan' => 'Unit usaha apa saja yang bisa dikembangkan oleh BUMDes?',
                'pilihan_a' => 'Hanya usaha pertanian',
                'pilihan_b' => 'Hanya usaha perdagangan',
                'pilihan_c' => 'Berbagai jenis usaha sesuai potensi desa',
                'pilihan_d' => 'Hanya usaha jasa',
                'jawaban_benar' => 'c',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriBumdes->id,
                'pertanyaan' => 'Bagaimana peran masyarakat dalam pengembangan BUMDes?',
                'pilihan_a' => 'Sebagai penonton saja',
                'pilihan_b' => 'Sebagai konsumen utama',
                'pilihan_c' => 'Berpartisipasi aktif dalam pengelolaan dan pengawasan',
                'pilihan_d' => 'Hanya sebagai penyedia modal',
                'jawaban_benar' => 'c',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriBumdes->id,
                'pertanyaan' => 'Sumber modal BUMDes dapat berasal dari mana saja?',
                'pilihan_a' => 'Hanya dari pemerintah desa',
                'pilihan_b' => 'Hanya dari pinjaman bank',
                'pilihan_c' => 'Pemerintah desa, masyarakat, dan pihak ketiga',
                'pilihan_d' => 'Hanya dari sumbangan',
                'jawaban_benar' => 'c',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($kategoriKPMD) {
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriKPMD->id,
                'pertanyaan' => 'Apa peran utama KPMD dalam pembangunan desa?',
                'pilihan_a' => 'Melakukan pengawasan keuangan desa',
                'pilihan_b' => 'Membantu perencanaan pembangunan desa',
                'pilihan_c' => 'Mengelola aset desa',
                'pilihan_d' => 'Menyusun peraturan desa',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriKPMD->id,
                'pertanyaan' => 'Siapa yang dapat menjadi anggota KPMD?',
                'pilihan_a' => 'Hanya perangkat desa',
                'pilihan_b' => 'Masyarakat desa yang memiliki kepedulian',
                'pilihan_c' => 'Hanya tokoh agama',
                'pilihan_d' => 'Hanya pengusaha lokal',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriKPMD->id,
                'pertanyaan' => 'Bagaimana KPMD berkontribusi dalam musrenbang desa?',
                'pilihan_a' => 'Sebagai peserta pasif',
                'pilihan_b' => 'Memberikan masukan dan usulan pembangunan',
                'pilihan_c' => 'Hanya mencatat hasil musrenbang',
                'pilihan_d' => 'Menentukan keputusan akhir',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriKPMD->id,
                'pertanyaan' => 'Apa singkatan dari KPMD?',
                'pilihan_a' => 'Kader Pembangunan Masyarakat Desa',
                'pilihan_b' => 'Komite Pembangunan Masyarakat Desa',
                'pilihan_c' => 'Kelompok Pemandu Masyarakat Desa',
                'pilihan_d' => 'Koperasi Pembangunan Masyarakat Desa',
                'jawaban_benar' => 'a',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriKPMD->id,
                'pertanyaan' => 'Tugas KPMD salah satunya adalah melakukan identifikasi potensi dan masalah desa. Benar atau salah?',
                'pilihan_a' => 'Benar',
                'pilihan_b' => 'Salah',
                'pilihan_c' => 'Tergantung kondisi',
                'pilihan_d' => 'Tidak relevan',
                'jawaban_benar' => 'a',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($kategoriMasyarakatHukumAdat) {
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriMasyarakatHukumAdat->id,
                'pertanyaan' => 'Apa yang dimaksud dengan Masyarakat Hukum Adat?',
                'pilihan_a' => 'Masyarakat yang tinggal di daerah terpencil',
                'pilihan_b' => 'Masyarakat yang memiliki hukum dan adat istiadat sendiri',
                'pilihan_c' => 'Masyarakat yang tidak memiliki pemerintahan',
                'pilihan_d' => 'Masyarakat yang hidup nomaden',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriMasyarakatHukumAdat->id,
                'pertanyaan' => 'Bagaimana pengakuan terhadap Masyarakat Hukum Adat di Indonesia?',
                'pilihan_a' => 'Tidak diakui',
                'pilihan_b' => 'Diakui dan dilindungi oleh konstitusi',
                'pilihan_c' => 'Diakui hanya di daerah tertentu',
                'pilihan_d' => 'Diakui jika memiliki izin khusus',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriMasyarakatHukumAdat->id,
                'pertanyaan' => 'Apa contoh hak tradisional Masyarakat Hukum Adat?',
                'pilihan_a' => 'Hak untuk memilih presiden',
                'pilihan_b' => 'Hak atas tanah ulayat',
                'pilihan_c' => 'Hak untuk mendirikan partai politik',
                'pilihan_d' => 'Hak untuk berdagang bebas',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriMasyarakatHukumAdat->id,
                'pertanyaan' => 'Apa peran hukum adat dalam kehidupan Masyarakat Hukum Adat?',
                'pilihan_a' => 'Sebagai pelengkap hukum negara',
                'pilihan_b' => 'Sebagai pedoman utama dalam mengatur kehidupan sosial',
                'pilihan_c' => 'Tidak memiliki peran',
                'pilihan_d' => 'Hanya berlaku untuk kasus pidana',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriMasyarakatHukumAdat->id,
                'pertanyaan' => 'Bagaimana cara melestarikan Masyarakat Hukum Adat?',
                'pilihan_a' => 'Mengisolasi mereka dari dunia luar',
                'pilihan_b' => 'Mendukung pengakuan hak-hak mereka dan melestarikan budaya',
                'pilihan_c' => 'Mengubah cara hidup mereka',
                'pilihan_d' => 'Membatasi akses pendidikan',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($kategoriPembangunanDesaWisata) {
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPembangunanDesaWisata->id,
                'pertanyaan' => 'Faktor utama dalam pengembangan desa wisata adalah?',
                'pilihan_a' => 'Modal yang besar',
                'pilihan_b' => 'Partisipasi masyarakat lokal',
                'pilihan_c' => 'Promosi yang gencar',
                'pilihan_d' => 'Infrastruktur modern',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPembangunanDesaWisata->id,
                'pertanyaan' => 'Apa manfaat ekonomi dari pengembangan desa wisata?',
                'pilihan_a' => 'Peningkatan pengangguran',
                'pilihan_b' => 'Peningkatan pendapatan masyarakat lokal',
                'pilihan_c' => 'Penurunan harga barang',
                'pilihan_d' => 'Peningkatan urbanisasi',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPembangunanDesaWisata->id,
                'pertanyaan' => 'Aspek apa yang penting dalam keberlanjutan desa wisata?',
                'pilihan_a' => 'Hanya keuntungan finansial',
                'pilihan_b' => 'Pelestarian budaya dan lingkungan',
                'pilihan_c' => 'Jumlah pengunjung yang banyak',
                'pilihan_d' => 'Pembangunan fasilitas mewah',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPembangunanDesaWisata->id,
                'pertanyaan' => 'Siapa saja pihak yang terlibat dalam pengembangan desa wisata?',
                'pilihan_a' => 'Hanya pemerintah daerah',
                'pilihan_b' => 'Masyarakat, pemerintah, dan swasta',
                'pilihan_c' => 'Hanya investor asing',
                'pilihan_d' => 'Hanya wisatawan',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPembangunanDesaWisata->id,
                'pertanyaan' => 'Apa yang harus diperhatikan dalam promosi desa wisata?',
                'pilihan_a' => 'Hanya menonjolkan keindahan alam',
                'pilihan_b' => 'Menyampaikan informasi yang akurat dan menarik',
                'pilihan_c' => 'Menggunakan bahasa yang sulit dimengerti',
                'pilihan_d' => 'Menyembunyikan kekurangan desa',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($kategoriCatrans) {
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriCatrans->id,
                'pertanyaan' => 'Apa fungsi utama Catrans dalam sistem informasi desa?',
                'pilihan_a' => 'Pengelolaan data penduduk',
                'pilihan_b' => 'Pencatatan transaksi keuangan',
                'pilihan_c' => 'Manajemen aset desa',
                'pilihan_d' => 'Pelaporan kegiatan desa',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriCatrans->id,
                'pertanyaan' => 'Catrans membantu dalam transparansi pengelolaan keuangan desa. Benar atau salah?',
                'pilihan_a' => 'Benar',
                'pilihan_b' => 'Salah',
                'pilihan_c' => 'Tergantung implementasi',
                'pilihan_d' => 'Tidak ada hubungannya',
                'jawaban_benar' => 'a',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriCatrans->id,
                'pertanyaan' => 'Data apa saja yang dapat dicatat menggunakan Catrans?',
                'pilihan_a' => 'Hanya data pribadi',
                'pilihan_b' => 'Data keuangan, aset, dan kegiatan desa',
                'pilihan_c' => 'Hanya data cuaca',
                'pilihan_d' => 'Hanya data kependudukan',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriCatrans->id,
                'pertanyaan' => 'Siapa pengguna utama aplikasi Catrans di desa?',
                'pilihan_a' => 'Masyarakat umum',
                'pilihan_b' => 'Perangkat desa',
                'pilihan_c' => 'Pelajar',
                'pilihan_d' => 'Wisatawan',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriCatrans->id,
                'pertanyaan' => 'Apa manfaat Catrans bagi akuntabilitas desa?',
                'pilihan_a' => 'Tidak ada manfaat',
                'pilihan_b' => 'Meningkatkan akuntabilitas dan pelaporan',
                'pilihan_c' => 'Memperumit proses',
                'pilihan_d' => 'Mengurangi partisipasi masyarakat',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($kategoriPelatihanPerencanaan) {
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPelatihanPerencanaan->id,
                'pertanyaan' => 'Mengapa perencanaan pembangunan partisipatif penting?',
                'pilihan_a' => 'Mempercepat proses pembangunan',
                'pilihan_b' => 'Memastikan semua pihak terlibat dan merasa memiliki',
                'pilihan_c' => 'Mengurangi biaya pembangunan',
                'pilihan_d' => 'Meningkatkan pendapatan desa',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPelatihanPerencanaan->id,
                'pertanyaan' => 'Siapa saja yang harus dilibatkan dalam perencanaan partisipatif?',
                'pilihan_a' => 'Hanya kepala desa',
                'pilihan_b' => 'Seluruh elemen masyarakat',
                'pilihan_c' => 'Hanya tokoh masyarakat',
                'pilihan_d' => 'Hanya perwakilan pemerintah',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPelatihanPerencanaan->id,
                'pertanyaan' => 'Apa tahapan awal dalam perencanaan partisipatif?',
                'pilihan_a' => 'Pelaksanaan proyek',
                'pilihan_b' => 'Identifikasi masalah dan potensi',
                'pilihan_c' => 'Evaluasi program',
                'pilihan_d' => 'Penyusunan laporan',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPelatihanPerencanaan->id,
                'pertanyaan' => 'Apa output dari proses perencanaan partisipatif?',
                'pilihan_a' => 'Laporan keuangan',
                'pilihan_b' => 'Rencana Pembangunan Jangka Menengah Desa (RPJMDes)',
                'pilihan_c' => 'Daftar hadir rapat',
                'pilihan_d' => 'Surat keputusan',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPelatihanPerencanaan->id,
                'pertanyaan' => 'Bagaimana memastikan partisipasi masyarakat berjalan efektif?',
                'pilihan_a' => 'Memaksa masyarakat hadir',
                'pilihan_b' => 'Menciptakan ruang diskusi yang inklusif dan terbuka',
                'pilihan_c' => 'Hanya mengundang perwakilan',
                'pilihan_d' => 'Memberikan insentif finansial',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($kategoriPrukades) {
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPrukades->id,
                'pertanyaan' => 'Apa tujuan utama program Prukades?',
                'pilihan_a' => 'Peningkatan kualitas pendidikan',
                'pilihan_b' => 'Pemberdayaan ekonomi desa',
                'pilihan_c' => 'Pembangunan infrastruktur',
                'pilihan_d' => 'Peningkatan kesehatan masyarakat',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPrukades->id,
                'pertanyaan' => 'Siapa sasaran utama program Prukades?',
                'pilihan_a' => 'Petani',
                'pilihan_b' => 'Pelaku usaha mikro dan kecil di desa',
                'pilihan_c' => 'Pegawai negeri sipil',
                'pilihan_d' => 'Mahasiswa',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPrukades->id,
                'pertanyaan' => 'Bentuk dukungan apa yang diberikan Prukades?',
                'pilihan_a' => 'Hanya bantuan uang tunai',
                'pilihan_b' => 'Pelatihan, pendampingan, dan akses permodalan',
                'pilihan_c' => 'Penyediaan lahan gratis',
                'pilihan_d' => 'Pemberian gelar kehormatan',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPrukades->id,
                'pertanyaan' => 'Bagaimana Prukades berkontribusi pada kemandirian ekonomi desa?',
                'pilihan_a' => 'Dengan menciptakan ketergantungan',
                'pilihan_b' => 'Dengan mendorong inovasi dan produktivitas lokal',
                'pilihan_c' => 'Dengan mengimpor produk dari luar',
                'pilihan_d' => 'Dengan membatasi jenis usaha',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPrukades->id,
                'pertanyaan' => 'Apa tantangan utama dalam implementasi Prukades?',
                'pilihan_a' => 'Kurangnya minat masyarakat',
                'pilihan_b' => 'Keterbatasan sumber daya dan kapasitas',
                'pilihan_c' => 'Terlalu banyak dukungan',
                'pilihan_d' => 'Tidak ada tantangan',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($kategoriPrudes) {
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPrudes->id,
                'pertanyaan' => 'Apa fokus utama dari program Prudes?',
                'pilihan_a' => 'Pengembangan potensi desa',
                'pilihan_b' => 'Peningkatan kapasitas aparatur desa',
                'pilihan_c' => 'Pengelolaan lingkungan desa',
                'pilihan_d' => 'Peningkatan keamanan desa',
                'jawaban_benar' => 'a',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPrudes->id,
                'pertanyaan' => 'Prudes bertujuan untuk mendorong kemandirian desa. Benar atau salah?',
                'pilihan_a' => 'Benar',
                'pilihan_b' => 'Salah',
                'pilihan_c' => 'Tergantung situasi',
                'pilihan_d' => 'Tidak relevan',
                'jawaban_benar' => 'a',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPrudes->id,
                'pertanyaan' => 'Bagaimana Prudes mendukung inovasi di desa?',
                'pilihan_a' => 'Dengan membatasi ide baru',
                'pilihan_b' => 'Dengan memfasilitasi pengembangan produk dan layanan baru',
                'pilihan_c' => 'Dengan hanya mengikuti tren',
                'pilihan_d' => 'Dengan menolak perubahan',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPrudes->id,
                'pertanyaan' => 'Apa peran teknologi dalam program Prudes?',
                'pilihan_a' => 'Tidak ada peran',
                'pilihan_b' => 'Mendukung efisiensi dan jangkauan program',
                'pilihan_c' => 'Menambah kerumitan',
                'pilihan_d' => 'Hanya untuk hiburan',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriPrudes->id,
                'pertanyaan' => 'Siapa yang paling diuntungkan dari program Prudes?',
                'pilihan_a' => 'Pemerintah pusat',
                'pilihan_b' => 'Masyarakat desa secara keseluruhan',
                'pilihan_c' => 'Perusahaan besar',
                'pilihan_d' => 'Hanya individu tertentu',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if ($kategoriEcomerce) {
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriEcomerce->id,
                'pertanyaan' => 'Apa manfaat utama e-commerce bagi UMKM desa?',
                'pilihan_a' => 'Mengurangi biaya produksi',
                'pilihan_b' => 'Memperluas jangkauan pasar',
                'pilihan_c' => 'Meningkatkan jumlah karyawan',
                'pilihan_d' => 'Mempercepat proses pengiriman',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriEcomerce->id,
                'pertanyaan' => 'Platform e-commerce apa yang cocok untuk produk desa?',
                'pilihan_a' => 'Hanya platform internasional',
                'pilihan_b' => 'Platform lokal dan nasional yang mudah diakses',
                'pilihan_c' => 'Hanya media sosial',
                'pilihan_d' => 'Tidak ada yang cocok',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriEcomerce->id,
                'pertanyaan' => 'Apa tantangan dalam menerapkan e-commerce di desa?',
                'pilihan_a' => 'Terlalu banyak pembeli',
                'pilihan_b' => 'Keterbatasan akses internet dan literasi digital',
                'pilihan_c' => 'Produk yang terlalu banyak',
                'pilihan_d' => 'Harga produk terlalu murah',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriEcomerce->id,
                'pertanyaan' => 'Bagaimana cara meningkatkan kepercayaan pembeli di e-commerce?',
                'pilihan_a' => 'Menyembunyikan informasi produk',
                'pilihan_b' => 'Memberikan deskripsi produk yang jelas dan jujur',
                'pilihan_c' => 'Menggunakan foto yang tidak sesuai',
                'pilihan_d' => 'Tidak merespon pertanyaan pembeli',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $soalData[] = [
                'id_kategori_soal_pelatihan' => $kategoriEcomerce->id,
                'pertanyaan' => 'Apa peran pemerintah dalam mendukung e-commerce desa?',
                'pilihan_a' => 'Tidak ada peran',
                'pilihan_b' => 'Memberikan pelatihan dan fasilitas',
                'pilihan_c' => 'Membatasi penjualan online',
                'pilihan_d' => 'Mengenakan pajak tinggi',
                'jawaban_benar' => 'b',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('soal_pelatihan')->insert($soalData);
    }
}