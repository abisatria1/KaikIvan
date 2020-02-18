// function--------------------
function formatDate(tanggal) {
    var myDate = new Date(tanggal);
    var month = ["Jan", "Febr", "Mar", "Ap", "May", "Jun",
        "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"
    ];
    var getMonth = month[myDate.getMonth()];
    return myDate.getDate() + " " + getMonth + " " + myDate.getFullYear();
}

function formatIndonesiaDate(tanggal) {
    var myDate = new Date(tanggal);
    var month = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    var getMonth = month[myDate.getMonth()];
    return getMonth + " " + myDate.getFullYear();
}

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}



function showOrderByMonth(strBulan, idJasa, tahun, bulan) {
    // format bulan Jan 2020
    $.ajax({
        url: `/jasa/showAll/${idJasa}/${strBulan}`,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            $('.table tbody').empty();
            $(data.dataOrder).each(function (i, item) {
                appendData(i, item);
            });
            $('#bulan').val(tahun + " " + bulan);
            $('#judul').text(formatIndonesiaDate(strBulan));
        },
        error: function (data) {
            alert('error on get data by month');
        }
    });
}

function appendData(i, data) {

    if (data.keterangan_order == null) {
        var keterangan = "";
    }
    if (data.status_bayar == 0) {
        var status = `
        <td class="custom-icon text-danger"><i class="fas fa-times"></i></td>`;
    } else {
        var status =
            `<td class="custom-icon text-success"><i class="fas fa-check"></i></td>`;
    }
    if (data.komisi_jasa == 0) {
        var string = `
        <tr class=table-danger>
            <td>${i+1}</td>
            <td>${formatDate(data.tanggal_order)}</td>
            <td>${data.nama_pelanggan}</td>
            <td>${data.notelp_pelanggan}</td>
            <td>${data.alamat_pelanggan}</td>
            <td>${data.jumlah_order}</td>
            <td>${addCommas(data.harga_order)}</td>
            <td>${data.komisi_jasa}</td>
            ${status}
            <td>${keterangan}</td>
        </tr>
        `;
    } else {
        var string = `
        <tr>
            <td>${i+1}</td>
            <td>${formatDate(data.tanggal_order)}</td>
            <td>${data.nama_pelanggan}</td>
            <td>${data.notelp_pelanggan}</td>
            <td>${data.alamat_pelanggan}</td>
            <td>${data.jumlah_order}</td>
            <td>${addCommas(data.harga_order)}</td>
            <td>${data.komisi_jasa}</td>
            ${status}
            <td>${keterangan}</td>
        </tr>
        `
    }

    $('.table tbody').append(string);
}

function setJudul(strMonth) {
    //var strMont = 2019-Jan
    var date = formatIndonesiaDate(strMonth);
    $('#judul').text(date);
}

function ubahWarnaBatal() {
    $('.komisi').each(function (i, elem) {
        var komisi = $(elem).val();
        if (komisi == 0) {
            $(elem).parents('tr').addClass('table-danger');
        }
    });
}





















// event handler ---------------------------------------------
$(document).ready(function () {
    setSelected('/jasa');
    ubahWarnaBatal();
    setJudul($('#bulan').val());
    // event untuk mengganti order 1 bulan ke kiri atau kanan
    $('#buttonMoveLeft').click(function () {
        var month = $('#bulan').val();
        var idJasa = $("#idJasa").val();
        var arr = (String(month)).split(' ');
        var tahun = arr[0];
        var bulan = arr[1];
        if (bulan == 1) {
            tahun--;
            bulan = 12;
        } else {
            bulan--;
        }
        showOrderByMonth(tahun + "-" + bulan, idJasa, tahun, bulan);
    });

    $('#buttonMoveRight').click(function () {
        var month = $('#bulan').val();
        var idJasa = $("#idJasa").val();
        var arr = (String(month)).split(' ');
        var tahun = arr[0];
        var bulan = arr[1];
        if (bulan == 12) {
            tahun++;
            bulan = 1;
        } else {
            bulan++;
        }
        showOrderByMonth(tahun + "-" + bulan, idJasa, tahun, bulan);
    });



});
