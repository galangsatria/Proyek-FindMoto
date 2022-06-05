<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Findmoto - Home</title>
    
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c3c1353c4c.js" crossorigin="anonymous"></script>
</head>
<body style="background-color: #F4F5FA;">
    <!-- Connector untuk menghubungkan PHP dan SPARQL -->
    <?php
        require_once("sparqllib.php");
        $test = "";
        if (isset($_POST['search'])) {
            $test = $_POST['search'];
            $data = sparql_get(
            "http://localhost:3030/Findmoto",
            "
            PREFIX info: <http://Findmoto.com/ns.data#> 
            PREFIX data:  <http://Findmoto.com/> 
            PREFIX rdf: <http://wwww3.org/1999/02/22-rdf-syntax-ns#>

            SELECT ?Nama_Motor ?Merek_Motor ?Tahun_produksi ?Jumlah_silinder ?CC ?Harga ?Type ?OS ?Brand ?TahunRilis
            WHERE
            { 
                ?items
                    info:Nama_Motor             ?Nama_Motor ;
                    info:Merek_Motor            ?Merek_Motor ;
                    info:Tahun_produksi         ?Tahun_produksi ;
                    info:Jumlah_silinder        ?Jumlah_silinder ;
                    info:CC                     ?CC .
                    FILTER 
                    (regex (?Nama_Motor, '$test', 'i') 
                    || regex (?Merek_Motor, '$test', 'i') 
                    || regex (?Tahun_produksi, '$test', 'i') 
                    || regex (?Jumlah_silinder, '$test', 'i') 
                    || regex (?CC, '$test', 'i'))
                    }"
            );
        } else {
            $data = sparql_get(
            "http://localhost:3030/Findmoto",
            "
                    PREFIX info: <http://Findmoto.com/ns.data#> 
                    PREFIX data:  <http://Findmoto.com/> 
                    PREFIX rdf: <http://wwww3.org/1999/02/22-rdf-syntax-ns#> 
                
                SELECT ?Nama_Motor ?Merek_Motor ?Tahun_produksi ?Jumlah_silinder ?CC 
                    WHERE
                    { 
                        ?items
                            info:Nama_Motor         ?Nama_Motor ;
                            info:Merek_Motor        ?Merek_Motor ;
                            info:Tahun_produksi     ?Tahun_produksi ;
                            info:Jumlah_silinder    ?Jumlah_silinder ;
                            info:CC                 ?CC .
                    }
            "
            );
        }

        if (!isset($data)) {
            print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
        }
    ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style="background-color: #0019FD;">
        <div class="container container-fluid">
        <form class="d-flex" role="search" action="" method="post" id="nameform" style="margin-left:20%;">
                    <input class="form-control me-2" type="search" placeholder="Ketik keyword disini" aria-label="Search" name="search" style="width:500px;">
                    <button class="btn btn-info" type="submit">Search</button>
                </form>
            <div class="collapse navbar-collapse float-end">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 h5 float-end" style="margin-left:60%;">
                    <li class="nav-item px-2">
                        <a class="nav-link active text-white" aria-current="page" href="#">Home</a>
                    </li>
                </ul>
                <a class="navbar-brand" href="index.php"><img src="src/img/logo.png" style="width:150px" alt="Logo"></a>
                
            </div>
        </div>
    </nav>

    <div class="container container-fluid mt-3  ">
        <i class="fa-solid fa-magnifying-glass"></i><span>Showing result : "<?php echo $test; ?>"</span>
        <table class="table table-bordered table-striped table-hover text-center">
            <thead class="table-primary">
                <tr>
                    <th>No.</th>
                    <th>Nama Motor</th>
                    <th>Merk Motor</th>
                    <th>Tahun Produksi</th>
                    <th>Jumlah Silinder</th>
                    <th>CC</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                <?php foreach ($data as $dat) : ?>
                <tr>
                    <td><?= ++$i ?></td>
                    <td><?= $dat['Nama_Motor'] ?></td>
                    <td><?= $dat['Merek_Motor'] ?></td>
                    <td><?= $dat['Tahun_produksi'] ?></td>
                    <td><?= $dat['Jumlah_silinder'] ?></td>
                    <td><?= $dat['CC'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="footer text-light text-center" style="background-color: #0019FD;">
        <p>Copyright &copy; FindMoto 2022 -<img src="src/img/logo.png" style="width:150px" alt="Logo"></p>
    </footer>
</body>
</html>