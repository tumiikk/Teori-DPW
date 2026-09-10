
let nama = prompt("Tuliskan nama Kamu");


if (nama !== null && nama.trim() !== "") {

    document.getElementById("nama").textContent = nama;

    document.getElementById("hasilNama").style.display = "block";
}