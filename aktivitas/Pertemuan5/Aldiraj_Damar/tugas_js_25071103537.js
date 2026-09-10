let namaKamu = "";

while (namaKamu === null || namaKamu.trim() === "") {
    namaKamu = prompt("Tuliskan nama Kamu");
}

let sapaan = document.getElementById("teks-sapaan");
sapaan.innerHTML = "Nama saya " + namaKamu + ", saya akan mengamalkan Pancasila dan UUD 1945 sebagai Dasar Negara.";

let konten = document.getElementById("konten-utama");
konten.style.display = "block"; 