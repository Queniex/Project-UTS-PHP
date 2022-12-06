<?php
session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'functions.php';
$id = $_GET["id"];
$item = query("SELECT id_nama, nama, alamat, hp, jenis_barang, barang.id_barang, nama_barang, harga, jumlah, harga*jumlah as total, tgl_transaksi FROM rusialdi INNER JOIN barang on rusialdi.id_barang=barang.id_barang WHERE rusialdi.id_nama = $id")[0]; //
$barang = mysqli_query($conn, "SELECT * FROM barang");

// checking is submit button has been press yet.
if ( isset($_POST["submit"]) ){
    
    if( edit($_POST) > 0 ){
       echo "
            <script>
                alert('Data berhasil diubah!')
                document.location.href = 'read.php'
            </script>
       "; 
    } else {
        echo "
            <script>
                alert('Data gagal diubah!')
                document.location.href = 'read.php'
            </script>
       ";
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="cupcake">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MacaroonMart | Login</title>

    <!-- Link daisyui -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.24.2/dist/full.css" rel="stylesheet" type="text/css" />

    <!-- Link tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
          theme: {
            container: {
              center: true,
              padding: '16px'
            },
            extend: {
              colors: {
                primary: '#14b8a6',
              },
              screens: {
                '2xl': '1320px',
              }
            }
          }
        }
      </script>

      <style type="text/tailwindcss">
        /* import font */
        @import url('https://fonts.googleapis.com/css2?family=Comic+Neue&family=Dosis:wght@500&family=Luckiest+Guy&family=Poppins:ital,wght@0,300;0,500;0,600;0,800;0,900;1,600&display=swap');

        @layer utilities {
         .hamburger-active > span:nth-child(1){
           @apply rotate-45;
         }

         @layer base {
          *{
            font-family: 'Poppins', sans-serif;
            color: black;
          }
         }

        /* *{
          border: 1px solid blue
         } */

        }
      </style>

</head>
<body>
    
<div class="bg-[#FFFBEB]">
        <div class="header h-[20vh]">
            <div class="md:flex justify-center">
                <div class="w-[70%] bg-white h-[12vh] border-black border-2 rounded-[80px] mt-4 mb-4 flex">
                    <div class="w-[70%] h-[12vh] rounded-l-[80px] flex">
                        <div class="ml-20 w-[20%] h-[12vh]"> 
                            <img style="height: 100%; width: 100%; object-fit: contain" src="images/macaroon.png" alt="">
                        </div>
                        <span style="-webkit-text-stroke-width: 1px;-webkit-text-stroke-color: black;" class="h-8 mt-2 text-[40px] font-bold text-[#F3E850]"><span class="text-[#FF0095]">Macaroon</span>mart</span>
                    </div>
                    <div class="w-[30%] h-[12vh] rounded-r-[80px] flex justify-center">
                        <div class="ml-16 mt-4 px-2">
                            <div class="flex items-stretch">

                              <div class="dropdown dropdown-end">
                                <label tabindex="0" class="btn bg-[#FFE898] text-black hover:text-white rounded-btn">Menu</label>
                                <ul tabindex="0" class="menu dropdown-content p-2 shadow bg-base-100 rounded-box w-52 mt-4">
                                  <li><a href="index.php">Dashboard</a></li> 
                                  <li><a href="read.php">Data</a></li>
                                </ul>
                              </div>

                              <a href="logout.php" class="ml-2 btn bg-[black] text-white hover:text-[pink] rounded-btn">Log Out</a>

                            </div>
                          </div>
                    </div>
                </div>
            </div>
            <!-- <center><h1><span class="a">Macaroon</span><span class="b">mart </span>|| 
                <span>
                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                        <a href="read.php" class="btn btn-outline-dark" >kembali</a>
                    </div>
                </span>
            </h1>
            </center> -->
        </div>

        <div class="isi h-[70vh] flex justify-center">
            <div class="h-[60vh] mt-1 w-[60%] flex justify-center">
                <form class="w-full max-w-lg" method="POST">
                    <div class="flex flex-wrap -mx-3 mb-3">
                      <div class="w-full md:w-1/2 px-3 mb-3 md:mb-0">
                        
                        <div>
                            <input type="hidden" name="id" value="<?= $item["id_nama"]; ?>">
                        </div>

                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="nama_pembeli">
                          Nama Pelanggan
                        </label>
                        <input class="border border-black appearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"  type="text" value="<?= $item["nama"]; ?>" id="nama_pembeli" name="nama_pembeli" required>
                      </div>
                      <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="hp">
                          Nomor HP
                        </label>
                        <input class="border border-black appearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"  type="text" value="<?= $item["hp"]; ?>" id="hp" name="hp" required>
                      </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-3">
                      <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="alamat">
                          Alamat
                        </label>
                        <input class="border border-black appearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"  type="text" value="<?= $item["alamat"]; ?>" id="alamat" name="alamat" required>
                      </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-6">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                              Nama Barang
                            </label>
                            <div class="relative">
                              <select name="id_barang" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">

                              <option for="grid-state" value=<?= $item['id_barang']; ?>> <?= $item['nama_barang']; ?> </option>
                              <?php foreach( $barang as $itm ) : ?>
                                    <option id="barang" value=<?= $itm['id_barang']; ?>> <?= $itm['nama_barang']; ?> </option>
                              <?php endforeach; ?> 
                              </select>
                              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                              </div>
                            </div>
                          </div>

                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-6">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                            Harga Barang
                            </label>
                            <div class="relative">
                            <select name="harga" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                            <option for="grid-state" value=<?= $item['harga']; ?>> <?= $item['harga']; ?> </option>
                            <?php foreach( $barang as $itm ) : ?>
                                <option id="barang" value=<?= $itm['harga_barang']; ?>> <?= $itm['harga_barang']; ?> </option>
                            <?php endforeach; ?>  
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-0 mb-0">
                            <div class="w-full md:w-1/2 px-3 mb-0 md:mb-0">
                              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="jumlah">
                                Kuantitas
                              </label>
                              <input class="border border-black appearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" value="<?= $item["jumlah"]; ?>" id="jumlah" name="jumlah" required type="text" >
                            </div>
                            <div class="w-full md:w-1/2 px-3">
                              <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="jenis_barang">
                                Jenis Barang
                              </label>
                              <input class="border border-black appearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" value="<?= $item["jenis_barang"]; ?>" id="jenis_barang" name="jenis_barang" required type="text">
                            </div>
                          </div>
                        </div>
                        
                        <button type="submit" name="submit" class="-mt-3 btn bg-[#F65A83] text-black hover:text-white rounded-btn">Update Data!</button>
                    </div>
                  </form>
            </div>
        </div>

        <div class="footer h-[10vh] bg-[#F65A83] flex justify-center">
            <center><p style="margin-top: 3vh;" class="text-white">&copy; Fildzah Marissa Rusialdi (2022)</p></center>
        </div>
   </div>
  
  
   

<!-- JQuery -->
<script
src="https://code.jquery.com/jquery-3.6.1.min.js"
integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
crossorigin="anonymous"></script>
<!-- Server -->
<script src="/fetch/script.js"></script>
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>