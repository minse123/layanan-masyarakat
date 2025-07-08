<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Soal Pelatihan</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; }
        .category-title { 
            font-size: 16px; 
            font-weight: bold; 
            margin-top: 25px; 
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ccc;
        }
        .question-block { margin-bottom: 15px; }
        .question { font-weight: bold; margin-bottom: 5px; }
        .options { list-style-type: none; padding-left: 15px; }
        .options li { margin-bottom: 3px; }
        .correct-answer { color: #28a745; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Daftar Soal Pelatihan</h1>
        <p>Dicetak pada: {{ date('d F Y H:i') }}</p>
    </div>

    @forelse($kategoriWithSoal as $kategori)
        <h2 class="category-title">{{ $kategori->nama_kategori }} ({{ ucfirst($kategori->tipe) }})</h2>
        
        @forelse($kategori->soalPelatihan as $index => $soal)
            <div class="question-block">
                <div class="question">{{ $index + 1 }}. {{ $soal->pertanyaan }}</div>
                <ul class="options">
                    <li>A. {{ $soal->pilihan_a }}</li>
                    <li>B. {{ $soal->pilihan_b }}</li>
                    <li>C. {{ $soal->pilihan_c }}</li>
                    <li>D. {{ $soal->pilihan_d }}</li>
                </ul>
                <div class="correct-answer">Jawaban Benar: {{ strtoupper($soal->jawaban_benar) }}</div>
            </div>
        @empty
            <p>Tidak ada soal dalam kategori ini.</p>
        @endforelse
    @empty
        <p>Tidak ada kategori soal yang tersedia.</p>
    @endforelse
</body>
</html>
