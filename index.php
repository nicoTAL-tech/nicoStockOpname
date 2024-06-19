<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config.php'; // Pastikan path ke config.php benar

// Proses penyimpanan data jika form di-submit
if (isset($_POST['Simpan'])) {
    $divisi = $_POST['divisi'];
    $namabarang = $_POST['namaBarang'];
    $stok = $_POST['stok'];
    $packaging = $_POST['packaging'];
    $berat_per_package = $_POST['berat'];
    $batch = $_POST['batch'];
    $kondisi = $_POST['kondisi'];
    $lokasi = $_POST['lokasi'];
    $timestamp = $_POST['timestamp'];
    $username = $_POST['username'];
    $cek = $_POST['cek'];
    $remark = $_POST['remark'];

    $query = "INSERT INTO stockopname (divisi, namabarang, stok, packaging, berat_per_package, batch, kondisi, lokasi, timestamp, username, cek, remark)
              VALUES ('$divisi', '$namabarang', '$stok', '$packaging', '$berat_per_package', '$batch', '$kondisi', '$lokasi', '$timestamp', '$username', '$cek', '$remark')";

    if (mysqli_query($connection, $query)) {
        echo "Data berhasil disimpan";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Opname</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h1 {
            margin: 0;
        }

        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        main {
            padding: 20px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-control:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 8px rgba(0,123,255,0.6);
        }

        .btn-submit {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-submit:hover {
            background-color: #45a049;
        }

        .modal-body {
            display: flex;
            flex-direction: column;
            gap: 15px; /* Menambahkan jarak antar kolom */
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <header>
        <h1>Data Barang</h1>
        <button id="btnTambah" class="btn">Tambah Barang</button>
        <div>
            <button id="btnLogout" class="btn">Logout</button>
        </div>
    </header>

    <main>
        <table class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Divisi</th>
                    <th>Lokasi</th>
                    <th>Nama Barang</th>
                    <th>Stok</th>
                    <th>Packaging</th>
                    <th>Berat per Package</th>
                    <th>Batch Number</th>
                    <th>Kondisi</th>
                    <th>Status</th>
                    <th>Remark</th> 
                    <th colspan="3" style="text-align: center;">Next</th>
                </tr>
            </thead>
            <tbody id="tbodyBarang">
                <?php
                if (isset($_POST["kirim"])) {
                    $search = $_POST['search'];
                    $query = mysqli_query($connection, "SELECT * FROM stockopname
                        WHERE lokasi LIKE '%".$search."%'
                        OR namabarang LIKE '%".$search."%'
                        ORDER BY SOID DESC
                    ");
                } else {
                    $query = mysqli_query($connection, "SELECT * FROM stockopname ORDER BY SOID DESC");
                }
                while ($row = mysqli_fetch_array($query)) { ?>
                    <tr>
                        <td><?php echo $SOID = $row['SOID']; ?></td>
                        <td><?php echo $row['divisi']; ?></td>
                        <td><?php echo $row['lokasi']; ?></td>
                        <td><?php echo $row['namabarang']; ?></td>
                        <td><?php echo $row['stok']; ?></td>
                        <td><?php echo $row['packaging']; ?></td>
                        <td><?php echo $row['berat_per_package']; ?></td>
                        <td><?php echo $row['batch']; ?></td>
                        <td><?php echo $row['kondisi']; ?></td>
                        <td><?php echo $row['cek']; ?></td>
                        <td><?php echo $row['remark']; ?></td>
                        <td > <a class="btn btn-submit" style="background:green; margin-left: 10px;" href="updatestatus.php?updatestatus=<?php echo $SOID?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16" style="align-content: center;">
  <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
</svg></a>
                    </td>

    <td style="align-content:center;"> <button style="background: red; padding-left: 10px; padding-right: 10px;"class="btn btn-danger btnEditRemark" data-soid="<?php echo $SOID; ?>" data-remark="<?php echo $row['remark']; ?>">NO</button></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Tambah Barang</h2>
            <form id="formBarang" method="POST">
                <div class="form-group">
                    <label for="divisi">Divisi:</label>
                    <input type="text" id="divisi" name="divisi" class="form-control">
                </div>
                <div class="form-group">
                    <label for="namaBarang">Nama Barang:</label>
                    <input type="text" id="namaBarang" name="namaBarang" class="form-control">
                </div>
                <div class="form-group">
                    <label for="stok">Stok:</label>
                    <input type="number" id="stok" name="stok" class="form-control">
                </div>
                <div class="form-group">
                    <label for="packaging">Packaging:</label>
                    <input type="text" id="packaging" name="packaging" class="form-control">
                </div>
                <div class="form-group">
                    <label for="berat">Berat per Package:</label>
                    <input type="number" id="berat" name="berat" class="form-control">
                </div>
                <div class="form-group">
                    <label for="batch">Batch Number:</label>
                    <input type="text" id="batch" name="batch" class="form-control">
                </div>
                <div class="form-group">
                    <label for="kondisi">Kondisi:</label>
                    <input type="text" id="kondisi" name="kondisi" class="form-control">
                </div>
                <div class="form-group">
                    <label for="lokasi">Lokasi:</label>
                    <input type="text" id="lokasi" name="lokasi" class="form-control">
                </div>
                <div class="form-group">
                    <label for="timestamp">Timestamp:</label>
                    <input type="datetime-local" id="timestamp" name="timestamp" class="form-control">
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" class="form-control">
                </div>
                <div class="form-group">
                    <label for="cek">Cek:</label>
                    <input type="text" id="cek" name="cek" class="form-control">
                </div>
                <div class="form-group">
                    <label for="remark">Remark:</label>
                    <input type="text" id="remark" name="remark" class="form-control">
                </div>
                <input type="submit" name="Simpan" class="btn-submit" value="Simpan">
            </form>
        </div>
    </div>

    <div id="updateRemarkModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Update Remark</h2>
            <form id="updateRemarkForm">
                <div class="form-group">
                    <label for="updateRemark">Remark:</label>
                    <input type="text" id="updateRemark" name="remark" class="form-control">
                </div>
                <input type="hidden" id="updateSOID" name="soid">
                <input type="submit" class="btn-submit" value="Update">
            </form>
        </div>
    </div>

    <script>
        document.getElementById('btnTambah').onclick = function() {
            document.getElementById('myModal').style.display = 'block';
        };

        document.querySelectorAll('.close').forEach(function(element) {
            element.onclick = function() {
                document.getElementById('myModal').style.display = 'none';
                document.getElementById('updateRemarkModal').style.display = 'none';
            };
        });

        window.onclick = function(event) {
            if (event.target == document.getElementById('myModal')) {
                document.getElementById('myModal').style.display = 'none';
            }
            if (event.target == document.getElementById('updateRemarkModal')) {
                document.getElementById('updateRemarkModal').style.display = 'none';
            }
        };

        document.getElementById('btnLogout').onclick = function() {
            window.location.href = 'logout.php';
        };

        document.querySelectorAll('.btnEditRemark').forEach(function(button) {
            button.onclick = function() {
                var soid = button.getAttribute('data-soid');
                var remark = button.getAttribute('data-remark');
                document.getElementById('updateSOID').value = soid;
                document.getElementById('updateRemark').value = remark;
                document.getElementById('updateRemarkModal').style.display = 'block';
            };
        });

        document.getElementById('updateRemarkForm').onsubmit = function(event) {
            event.preventDefault();
            var soid = document.getElementById('updateSOID').value;
            var remark = document.getElementById('updateRemark').value;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_remark.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status == 200) {
                    alert('Remark updated successfully!');
                    location.reload();
                } else {
                    alert('Error updating remark.');
                }
            };
            xhr.send('soid=' + soid + '&remark=' + remark);
        };
    </script>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
</body>
</html>
