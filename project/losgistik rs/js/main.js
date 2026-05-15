(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();


    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
        return false;
    });


    // Sidebar Toggler
    $('.sidebar-toggler').click(function () {
        $('.sidebar, .content').toggleClass("open");
        return false;
    });


    // Progress Bar
    $('.pg-bar').waypoint(function () {
        $('.progress .progress-bar').each(function () {
            $(this).css("width", $(this).attr("aria-valuenow") + '%');
        });
    }, { offset: '80%' });


    // Calender
    $('#calender').datetimepicker({
        inline: true,
        format: 'L'
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        items: 1,
        dots: true,
        loop: true,
        nav: false
    });


    // Chart Global Color
    Chart.defaults.color = "#6C7293";
    Chart.defaults.borderColor = "#000000";


    // Worldwide Sales Chart
    var ctx1 = $("#worldwide-sales").get(0).getContext("2d");
    var myChart1 = new Chart(ctx1, {
        type: "bar",
        data: {
            labels: ["2016", "2017", "2018", "2019", "2020", "2021", "2022"],
            datasets: [{
                label: "USA",
                data: [15, 30, 55, 65, 60, 80, 95],
                backgroundColor: "rgba(235, 22, 22, .7)"
            },
            {
                label: "UK",
                data: [8, 35, 40, 60, 70, 55, 75],
                backgroundColor: "rgba(235, 22, 22, .5)"
            },
            {
                label: "AU",
                data: [12, 25, 45, 55, 65, 70, 60],
                backgroundColor: "rgba(235, 22, 22, .3)"
            }
            ]
        },
        options: {
            responsive: true
        }
    });


    // Salse & Revenue Chart
    var ctx2 = $("#salse-revenue").get(0).getContext("2d");
    var myChart2 = new Chart(ctx2, {
        type: "line",
        data: {
            labels: ["2016", "2017", "2018", "2019", "2020", "2021", "2022"],
            datasets: [{
                label: "Salse",
                data: [15, 30, 55, 45, 70, 65, 85],
                backgroundColor: "rgba(235, 22, 22, .7)",
                fill: true
            },
            {
                label: "Revenue",
                data: [99, 135, 170, 130, 190, 180, 270],
                backgroundColor: "rgba(235, 22, 22, .5)",
                fill: true
            }
            ]
        },
        options: {
            responsive: true
        }
    });



    // Single Line Chart
    var ctx3 = $("#line-chart").get(0).getContext("2d");
    var myChart3 = new Chart(ctx3, {
        type: "line",
        data: {
            labels: [50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150],
            datasets: [{
                label: "Salse",
                fill: false,
                backgroundColor: "rgba(235, 22, 22, .7)",
                data: [7, 8, 8, 9, 9, 9, 10, 11, 14, 14, 15]
            }]
        },
        options: {
            responsive: true
        }
    });


    // Single Bar Chart
    var ctx4 = $("#bar-chart").get(0).getContext("2d");
    var myChart4 = new Chart(ctx4, {
        type: "bar",
        data: {
            labels: ["Italy", "France", "Spain", "USA", "Argentina"],
            datasets: [{
                backgroundColor: [
                    "rgba(235, 22, 22, .7)",
                    "rgba(235, 22, 22, .6)",
                    "rgba(235, 22, 22, .5)",
                    "rgba(235, 22, 22, .4)",
                    "rgba(235, 22, 22, .3)"
                ],
                data: [55, 49, 44, 24, 15]
            }]
        },
        options: {
            responsive: true
        }
    });


    // Pie Chart
    var ctx5 = $("#pie-chart").get(0).getContext("2d");
    var myChart5 = new Chart(ctx5, {
        type: "pie",
        data: {
            labels: ["Italy", "France", "Spain", "USA", "Argentina"],
            datasets: [{
                backgroundColor: [
                    "rgba(235, 22, 22, .7)",
                    "rgba(235, 22, 22, .6)",
                    "rgba(235, 22, 22, .5)",
                    "rgba(235, 22, 22, .4)",
                    "rgba(235, 22, 22, .3)"
                ],
                data: [55, 49, 44, 24, 15]
            }]
        },
        options: {
            responsive: true
        }
    });


    // Doughnut Chart
    var ctx6 = $("#doughnut-chart").get(0).getContext("2d");
    var myChart6 = new Chart(ctx6, {
        type: "doughnut",
        data: {
            labels: ["Italy", "France", "Spain", "USA", "Argentina"],
            datasets: [{
                backgroundColor: [
                    "rgba(235, 22, 22, .7)",
                    "rgba(235, 22, 22, .6)",
                    "rgba(235, 22, 22, .5)",
                    "rgba(235, 22, 22, .4)",
                    "rgba(235, 22, 22, .3)"
                ],
                data: [55, 49, 44, 24, 15]
            }]
        },
        options: {
            responsive: true
        }
    });


})(jQuery);


//show
$(document).ready(function () {
    // Fungsi untuk menampilkan daftar barang
    function tampilkanDaftarBarang() {
        $.ajax({
            url: "tampilkan_barang.php",
            type: "GET",
            success: function (response) {
                // Masukkan data barang ke dalam tabel
                $('#daftarBarang').html(response);
            },
            error: function (xhr, status, error) {
                // Tampilkan pesan error jika terjadi masalah
                console.error(xhr.responseText);
            }
        });
    }

    // Menampilkan daftar barang saat halaman dimuat
    tampilkanDaftarBarang();
});

//stok
function updateStokBarang(idBarang, jumlahMasuk) {
    var stokElement = document.getElementById('stok_' + idBarang);
    var stokBaru = parseInt(stokElement.innerText) + jumlahMasuk;
    stokElement.innerText = stokBaru;
}

// Fungsi untuk memperbarui stok barang di halaman barang.php
function updateStokBarang(id_barang, jumlah_masuk) {
    // Mengambil elemen dengan ID stok_{id_barang}
    var stokElement = document.getElementById('stok_' + id_barang);

    // Mendapatkan nilai stok saat ini dari elemen
    var stokSaatIni = parseInt(stokElement.innerHTML);

    // Menghitung stok baru setelah barang masuk
    var stokBaru = stokSaatIni + jumlah_masuk;

    // Memperbarui nilai stok di halaman
    stokElement.innerHTML = stokBaru;
}

// Memuat daftar barang saat halaman dimuat
window.onload = function () {
    loadDaftarBarang();
};

function loadDaftarBarang() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("daftarBarang").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "tampilkan_barang.php", true);
    xhttp.send();
}

function getBarangInfo() {
    var idBarang = document.getElementById("id_barang").value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            document.getElementById("nama_barang").value = response.nama_barang;
            document.getElementById("kategori").value = response.kategori;
        }
    };
    xhttp.open("GET", "get_barang_info.php?id_barang=" + idBarang, true);
    xhttp.send();
}

function getBarangInfo(idBarang) {
    if (idBarang) {
        fetch(`get_barang_info.php?id_barang=${idBarang}`)
            .then(response => response.json())
            .then(data => {
                // Pastikan elemen input/teks untuk nama barang dan kategori diisi sesuai data
                document.getElementById('nama_barang').value = data.nama_barang || '';
                document.getElementById('kategori').value = data.kategori || '';
            })
            .catch(error => {
                console.error('Error:', error);
                // Bersihkan nilai jika terjadi kesalahan atau barang tidak ditemukan
                document.getElementById('nama_barang').value = '';
                document.getElementById('kategori').value = '';
            });
    } else {
        // Bersihkan form jika ID barang tidak valid atau tidak dipilih
        document.getElementById('nama_barang').value = '';
        document.getElementById('kategori').value = '';
    }
}


function getBarangInfo() {
    var id_barang = document.getElementById("id_barang").value;

    // Lakukan request AJAX untuk mendapatkan informasi barang berdasarkan ID
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_barang_info.php?id_barang=" + id_barang, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            document.getElementById("nama_barang").value = response.nama_barang;
            document.getElementById("kategori").value = response.kategori;
        }
    };
    xhr.send();
}

// After form submission, update the status message
document.querySelector('.alert').innerText = 'Status: Permintaan Dikirim'; // Change the text as needed

$(document).ready(function () {
    // Submit form via AJAX
    $('#permintaanForm').on('submit', function (e) {
        e.preventDefault(); // Mencegah refresh halaman
        var formData = $(this).serialize(); // Ambil data dari form

        // Tampilkan status "Menunggu Konfirmasi"
        $('#statusPermintaan').html('<div class="alert alert-warning">Menunggu Konfirmasi...</div>');

        $.ajax({
            url: 'proses_permintaan_barang.php', // URL ke script PHP yang memproses permintaan
            type: 'POST',
            data: formData,
            success: function (response) {
                // Panggil fungsi untuk mengecek status permintaan setelah submit
                checkStatusPermintaan(response.id_permintaan);
            },
            error: function () {
                Swal.fire('Error', 'Gagal mengirim permintaan!', 'error');
            }
        });
    });

    // Fungsi untuk mengecek status permintaan dari server
    function checkStatusPermintaan(idPermintaan) {
        // Interval pengecekan status setiap 5 detik
        var interval = setInterval(function () {
            $.ajax({
                url: 'cek_status_permintaan.php', // File PHP untuk mengecek status permintaan
                type: 'POST',
                data: { id_permintaan: idPermintaan },
                success: function (response) {
                    // Jika permintaan sudah di-update, tampilkan notifikasi
                    if (response.status === 'diterima') {
                        Swal.fire('Berhasil', 'Permintaan Anda telah diterima!', 'success');
                        $('#statusPermintaan').html('<div class="alert alert-success">Permintaan Berhasil!</div>');
                        clearInterval(interval); // Hentikan interval jika sudah berhasil
                    } else if (response.status === 'ditolak') {
                        Swal.fire('Ditolak', 'Permintaan Anda telah ditolak!', 'error');
                        $('#statusPermintaan').html('<div class="alert alert-danger">Permintaan Ditolak!</div>');
                        clearInterval(interval); // Hentikan interval jika sudah ditolak
                    }
                }
            });
        }, 5000); // Cek status setiap 5 detik
    }
});


function showRejectModal(permintaanId) {
    // Set the permintaan ID in the hidden field
    document.getElementById('permintaan_id').value = permintaanId;

    // Show the modal
    var rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
    rejectModal.show();
}

function showAcceptModal(id) {
    document.getElementById("acceptId").value = id;
    var modal = new bootstrap.Modal(document.getElementById('acceptModal'));
    modal.show();
}

function showAcceptModal(id) {
    document.getElementById("acceptId").value = id;
    var modal = new bootstrap.Modal(document.getElementById('acceptModal'));
    modal.show();
}

function submitAccept() {
    const id = document.getElementById('acceptId').value;
    const keterangan = document.getElementById('keteranganTerima').value;

    $.ajax({
        url: 'proses_konfirmasi.php?id=' + id + '&action=terima',
        type: 'POST',
        data: {
            keterangan: keterangan
        },
        success: function (response) {
            Swal.fire('Berhasil!', 'Permintaan diterima.', 'success').then(() => {
                window.location.reload();
            });
        },
        error: function () {
            Swal.fire('Gagal!', 'Terjadi kesalahan saat menerima permintaan.', 'error');
        }
    });
}

function showRejectModal(id) {
    // Set ID permintaan ke dalam input hidden
    document.getElementById("rejectId").value = id; 
    // Tampilkan modal
    var modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    modal.show();
}

function submitReject() {
    const id = document.getElementById('rejectId').value; // Ambil ID permintaan
    const keterangan = document.getElementById('keterangan').value; // Ambil keterangan

    // Kirim data ke proses_penolakan.php
    $.ajax({
        url: 'proses_penolakan.php',
        type: 'POST',
        data: {
            id_permintaan: id,
            keterangan: keterangan
        },
        success: function (response) {
            Swal.fire('Berhasil!', 'Permintaan ditolak.', 'success').then(() => {
                window.location.reload(); // Reload halaman setelah berhasil
            });
        },
        error: function () {
            Swal.fire('Gagal!', 'Terjadi kesalahan saat menolak permintaan.', 'error');
        }
    });
}