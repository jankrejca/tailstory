function filtrObyvatel() {
    baseUrl = window.location.href.split("?")[0]; // získá URL bez parametrů
    window.history.pushState('name', '', baseUrl); // nastaví URL bez parametrů
}