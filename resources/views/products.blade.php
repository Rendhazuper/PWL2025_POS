<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Point Of Sales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Our Products</h1>
        <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card">
                    <div class="card-body text-center">
                            <h5 class="card-title">Food & Baverage</h5>
                            <a href="{{ url('/category/food-beverage') }}" class="btn btn-primary">Pilih</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Beauty health</h5>
                            <a href="{{ url('/category/beauty-health')}}" class="btn btn-primary">Pilih</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Home Care</h5>
                            <a href="{{ url('/category/home-care') }}" class="btn btn-primary">Pilih</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Baby & Kid</h5>
                            <a href="{{ url('/category/baby-kid') }}" class="btn btn-primary">Pilih</a>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
