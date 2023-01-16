/*
https:\/\/api.dicebear.com\/5.x\/adventurer-neutral\/svg?seed=1admin@admin.comPedro

This function remove all \/\ and let only single /
*/

function clearUrl(url) {
    return url.replace(/\/\//g, '/');
}

// Export
module.exports = clearUrl;