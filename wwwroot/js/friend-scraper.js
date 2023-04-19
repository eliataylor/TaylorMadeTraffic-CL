const json = {};
function addLinks(parent, sel) {
    const links = parent.querySelectorAll(sel);
    for (let i in links) {
        json[links[i].href] = links[i].innerText;
    }
    console.log('total links: ' + Object.keys(json).length);
}

function loadMore() {
    window.scroll({ top: 0, behavior: 'smooth' });
    setTimeout(() => {
        window.scroll({top: container.scrollHeight, behavior: 'smooth'});
        setTimeout(() => {
            addLinks(parent, 'a[href*="profile.php"]')
        }, 2000)
    }, 1000)
}

const container = document.querySelector(".x78zum5.x1q0g3np.x1a02dak.x1qughib")
addLinks(container, 'a[href]');
let test = setInterval(loadMore, 4000);
