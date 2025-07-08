@if($soalList->isEmpty())
    <div class="alert alert-info">Tidak ada soal untuk kategori ini.</div>
@else
    @foreach($soalList as $index => $soal)
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h6 class="mb-0">Soal #{{ $index + 1 }}</h6>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $soal->pertanyaan }}</p>
                <input type="hidden" name="jawaban[{{ $index }}][id_soal]" value="{{ $soal->id }}">
                
                <!-- Pilihan A -->
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" 
                            id="pilihan_a_{{ $soal->id }}" 
                            name="jawaban[{{ $index }}][jawaban_peserta]" 
                            value="a" 
                            {{ isset($jawabanPeserta[$soal->id]) && $jawabanPeserta[$soal->id] === 'a' ? 'checked' : '' }} 
                            required>
                        <label class="custom-control-label" for="pilihan_a_{{ $soal->id }}">
                            A. {{ $soal->pilihan_a }}
                        </label>
                    </div>
                </div>
                
                <!-- Pilihan B -->
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" 
                            id="pilihan_b_{{ $soal->id }}" 
                            name="jawaban[{{ $index }}][jawaban_peserta]" 
                            value="b" 
                            {{ isset($jawabanPeserta[$soal->id]) && $jawabanPeserta[$soal->id] === 'b' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="pilihan_b_{{ $soal->id }}">
                            B. {{ $soal->pilihan_b }}
                        </label>
                    </div>
                </div>
                
                <!-- Pilihan C -->
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" 
                            id="pilihan_c_{{ $soal->id }}" 
                            name="jawaban[{{ $index }}][jawaban_peserta]" 
                            value="c" 
                            {{ isset($jawabanPeserta[$soal->id]) && $jawabanPeserta[$soal->id] === 'c' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="pilihan_c_{{ $soal->id }}">
                            C. {{ $soal->pilihan_c }}
                        </label>
                    </div>
                </div>
                
                <!-- Pilihan D -->
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" 
                            id="pilihan_d_{{ $soal->id }}" 
                            name="jawaban[{{ $index }}][jawaban_peserta]" 
                            value="d" 
                            {{ isset($jawabanPeserta[$soal->id]) && $jawabanPeserta[$soal->id] === 'd' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="pilihan_d_{{ $soal->id }}">
                            D. {{ $soal->pilihan_d }}
                        </label>
                    </div>
                </div>
                
                <!-- Jawaban Benar (hanya tampil di mode edit) -->
                @if(isset($jawabanPeserta[$soal->id]))
                <div class="alert alert-{{ $jawabanPeserta[$soal->id] === $soal->jawaban_benar ? 'success' : 'danger' }} p-2 mb-0">
                    <small class="d-flex align-items-center">
                        <i class="fas {{ $jawabanPeserta[$soal->id] === $soal->jawaban_benar ? 'fa-check-circle' : 'fa-times-circle' }} mr-2"></i>
                        @if($jawabanPeserta[$soal->id] === $soal->jawaban_benar)
                            Jawaban Anda benar
                        @else
                            Jawaban Anda salah. Jawaban benar: <strong class="ml-1">{{ strtoupper($soal->jawaban_benar) }}</strong>
                        @endif
                    </small>
                </div>
                @else
                <div class="alert alert-info p-2 mb-0">
                    <small class="d-flex align-items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Pilih salah satu jawaban yang benar
                    </small>
                </div>
                @endif
            </div>
        </div>
    @endforeach
@endif
