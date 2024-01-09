@extends('layouts.user.app2')

@section('content2')

<main id="main">
<section id="leaderboard" class="leaderboard">
  <div class="container">
    <div class="section-title">
    <p id="rankingTitle"> Peringkat tahun 2023</p>

<script>
  // Mengambil elemen h2 berdasarkan ID
  var h2Element = document.getElementById("rankingTitle");

  // Mendapatkan tahun saat ini
  var currentYear = new Date().getFullYear();

  // Mengganti teks tahun dalam elemen h2
  h2Element.innerHTML = h2Element.innerHTML.replace("2023", currentYear - 1);
</script>

    
    </div>



    
    <div class="card mb-3">
  <div class="card-body">
  @if($leaderboardData->isEmpty())
                    <p class="text-sm">
               
                    <small class="text-muted">
                        Belum ada peringkat
                    </small>

                    </p>  

                    @else
                    
                    <h4 class="text-bold mb-10 mt-2">
                        <span class="user-rank"> Peringkat Anda : {{$userRank}}</span>   <span class="total-user">/ {{$totalUsersWithSameRole}} </span> 
                        </h4>

                        <p class="text-sm">
                <small class="text-muted">
                Anda menduduki posisi ke {{$userRank}} dari {{$totalUsersWithSameRole}}
            </small>

            </p>  
                        @endif  </div>
</div>

<hr class="solid">

    @if (count($leaderboardData) > 0)
    <ul class="leaderboard-list">
      @foreach ($leaderboardData as $leader)
      <li class="leaderboard-item @if ($loop->first) leaderboard-first @elseif ($loop->iteration == 2) leaderboard-second @elseif ($loop->iteration == 3) leaderboard-third @endif">
                <div class="leaderboard-rank">
          <span class="rank-number">#{{ $loop->iteration }}</span>
        </div>
        <div class="leaderboard-avatar">
          <!-- Cek apakah ada gambar avatar sesuai dengan nama user -->
          @if ($leader->user)
          @if ($leader->user->avatar)
          <img src="{{ asset('img/' . $leader->user->avatar) }}" alt="{{ $leader->nama }} Avatar" width="50" height="50" style="border-radius: 100%;">
          @else
          <!-- Jika tidak ada avatar, Anda bisa menampilkan gambar default di sini -->
          <img src="{{ asset('img/default-profile.jpg') }}" alt="Default Avatar" width="50" height="50" style="border-radius: 100%;">
          @endif
          @else
          <!-- Jika tidak ada data pengguna yang sesuai, Anda bisa menampilkan gambar default di sini -->
          <img src="{{ asset('img/default-profile.jpg') }}" alt="Default Avatar" width="50" height="50" style="border-radius: 100%;">
          @endif
        </div>

        <div class="leaderboard-info">
          <h4>{{ $leader->user->nama }}</h4>
          <p>Total : {{ $leader->total_point}}</p>
          
        </div>
      </li>
      @endforeach
    </ul>
    @else
    <p>Tidak ada data leaderboard yang tersedia saat ini.</p>
            @endif

    <!-- Tombol untuk melihat lebih banyak -->
   
  </div>

  
</section>

</main>

<style>


input[type="month"] {
            width: 20%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

hr.solid {
  border-top: 2px solid  #FF5733; 
  margin-bottom : 15px;
}
.user-rank {
    font-size: 34px; /* Ubah ukuran teks sesuai preferensi Anda */
    color: #FF5733; /* Ubah warna teks sesuai preferensi Anda */
    font-weight: bold; /* Membuat teks menjadi tebal */
    margin-right: 5px; /* Memberikan jarak sebelum tanda "/" */
}

.total-user {
    font-size: 30px;
    color: gray; 

}

  .card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);

  }
  

    /* Mengatur tampilan daftar leaderboard */
.leaderboard-list {
  list-style: none;
  padding: 0;
}

.leaderboard-item {
  border: 2px solid #01004C; /* Warna border item leaderboard */
  margin-bottom: 10px; /* Jarak antara item leaderboard */
  display: flex;
  align-items: center;
  padding: 10px;
  background-color: #f8f9fa; /* Warna latar belakang item leaderboard */
  border-radius: 8px;
}

.leaderboard-rank {
  font-size: 24px; /* Ukuran angka rank yang lebih kecil */
  color: #01004C; /* Warna angka rank */
  flex: 0 0 50px; /* Lebar tetap untuk rank */
}

.rank-number {
  font-weight: bold; /* Membuat angka rank lebih tebal */
}

.leaderboard-avatar img {
  width: 80px;
  height: 80px;
  border-radius: 100%;
  object-fit: cover;
  margin-right: 10px;
}

.leaderboard-first {
        /* Gaya kartu untuk peringkat pertama */
        border: 4px solid #FFD700; /* Warna border lebih tebal untuk peringkat pertama */
        padding: 20px; /* Lebih besar padding untuk peringkat pertama */
        background-color: #E6E8FA; /* Warna latar belakang berbeda untuk peringkat pertama */
    }

   .leaderboard-second {
        /* Gaya kartu untuk peringkat pertama */
        border: 4px solid #d6d6d6; /* Warna border lebih tebal untuk peringkat pertama */
        padding: 20px; /* Lebih besar padding untuk peringkat pertama */
        background-color: #E6E8FA; /* Warna latar belakang berbeda untuk peringkat pertama */
    }

    .leaderboard-third {
        /* Gaya kartu untuk peringkat pertama */
        border: 4px solid #CD7F32; /* Warna perunggu (bronze) */
                padding: 20px; /* Lebih besar padding untuk peringkat pertama */
        background-color: #E6E8FA; /* Warna latar belakang berbeda untuk peringkat pertama */
    }


.leaderboard-info {
  flex: 1;
  margin-top:12px;
}

/* Gaya tombol "Lihat daftar ranking" */
.btn-lain a {
  text-decoration: none;
  color: #ffffff;
  background-color: #01004C;
  padding: 10px 20px;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.btn-lain a:hover {
  background-color: #FFD700; /* Warna latar belakang tombol saat dihover */
}

</style>
@endsection