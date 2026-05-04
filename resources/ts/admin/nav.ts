// Menggunakan Type Casting (HTMLDivElement atau HTMLElement)
const sideBar = document.querySelector(".sidebar") as HTMLElement;

const btnOpenSidebar = document.querySelector("#open-sidebar") as HTMLButtonElement;
const btnCloseSidebar = document.querySelector("#close-sidebar") as HTMLButtonElement;

// Optional Chaining (?.) digunakan untuk berjaga-jaga jika elemen tidak ditemukan di DOM
btnOpenSidebar?.addEventListener("click", (): void => {
    sideBar?.classList.remove("-translate-x-full");
});

btnCloseSidebar?.addEventListener("click", (): void => {
    sideBar?.classList.add("-translate-x-full");
});