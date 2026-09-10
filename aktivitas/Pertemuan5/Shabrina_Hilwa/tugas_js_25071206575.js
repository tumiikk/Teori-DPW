window.onload = function() {
    let modalOverlay = document.getElementById("modal-overlay");
    let inputNama = document.getElementById("inputNama");
    let btnOke = document.getElementById("btnOke");
    let btnBatal = document.getElementById("btnBatal");
    let wadahSapaan = document.getElementById("sapaan");

    function prosesInput() {
        let namaUser = inputNama.value.trim();
        if (namaUser !== "") {
            wadahSapaan.innerHTML = "Nama saya <b>" + namaUser + "</b>, saya akan mengamalkan Pancasila dan UUD 1945 sebagai Dasar Negara.";
            modalOverlay.classList.add("hidden");
        }
    }

    // Aksi saat tombol Oke diklik
    btnOke.onclick = prosesInput;

    // Aksi saat menekan tombol Enter pada keyboard
    inputNama.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            prosesInput();
        }
    });

    // Aksi saat tombol Batal diklik
    btnBatal.onclick = function() {
        modalOverlay.classList.add("hidden");
    };
};