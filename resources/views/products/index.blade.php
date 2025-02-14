@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1 class="text-center mb-4">🎮 Toko Game Digital 🎮</h1>

        <!-- Search & Sort -->
        <div class="row mb-4">
            <div class="col-md-6">
                <input type="text" id="searchBox" class="form-control" placeholder="🔍 Cari game..." onkeyup="fetchGames()">

            </div>
            <div class="col-md-6 text-end">
                <select id="sortPrice" class="form-select w-auto d-inline" onchange="sortGames()">
                    <option value="default">Urutkan Harga</option>
                    <option value="low">Termurah</option>
                    <option value="high">Termahal</option>
                </select>
            </div>
        </div>

        <!-- Game List -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="gameList">
            @foreach ($products as $product)
                <div class="col">
                    <div class="card game-card shadow-lg border-0">
                        <div class="card-img-container">
                            <img src="{{ asset($product->image_url) }}" class="card-img-top" alt="{{ $product->name }}">
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($product->description, 60) }}</p>
                            <p class="card-text text-danger fw-bold price" data-price="{{ $product->price }}">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-gradient btn-sm">Lihat
                                Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links('pagination::simple-bootstrap-5') }}

        </div>

    </div>

    <!-- Styles -->
    <style>
        .game-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
            background: #fff;
        }

        .game-card .card-body .card-title {
            color: linear-gradient(to right, #141e30, #243b55);
        }

        .game-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
        }

        .card-img-container {
            width: 100%;
            height: 200px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f8f9fa;
        }

        .card-img-container img {
            max-height: 100%;
            max-width: 100%;
            object-fit: cover;
        }

        .btn-gradient {
            background: linear-gradient(to right, #141e30, #243b55);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            transition: 0.3s;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .btn-gradient:hover {
            background: linear-gradient(to left, #141e30, #243b55);
            color: white;
        }

        .pagination {
            justify-content: flex-end;
            margin-top: 20px;
        }

        .pagination .page-link {
            border: none;
            background: none;
            color: #333;
            font-weight: bold;
            padding: 5px 10px;
        }

        .pagination .page-link:hover {
            color: #ff4b2b;
        }

        .pagination .active .page-link {
            color: #ff4b2b;
            font-weight: bold;
        }


        @media (max-width: 768px) {
            .game-card {
                margin-bottom: 20px;
            }

            .card-img-container {
                height: 150px;
            }
        }
    </style>

    <!-- JavaScript -->
    <script>
        function fetchGames() {
            let query = document.getElementById("searchBox").value;

            fetch(`?search=${query}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById("gameList").innerHTML =
                        new DOMParser().parseFromString(html, "text/html").querySelector("#gameList").innerHTML;
                })
                .catch(error => console.error("Error fetching games:", error));
        }


        function searchGames() {
            let input = document.getElementById("searchBox").value.toLowerCase();
            let cards = document.querySelectorAll(".col");

            cards.forEach(card => {
                let title = card.querySelector(".card-title").innerText.toLowerCase();
                card.style.display = title.includes(input) ? "block" : "none";
            });
        }

        function sortGames() {
            let gameList = document.getElementById("gameList");
            let cards = Array.from(document.querySelectorAll(".col"));
            let sortBy = document.getElementById("sortPrice").value;

            if (sortBy !== "default") {
                cards.sort((a, b) => {
                    let priceA = parseInt(a.querySelector(".price").getAttribute("data-price"));
                    let priceB = parseInt(b.querySelector(".price").getAttribute("data-price"));

                    return sortBy === "low" ? priceA - priceB : priceB - priceA;
                });

                cards.forEach(card => gameList.appendChild(card));
            }
        }
    </script>
@endsection
