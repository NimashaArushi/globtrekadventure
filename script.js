function openPanel(type) {
    document.getElementById("sidePanel").style.width = "400px"; // Panel එක එළියට එනවා
    
    const name = document.getElementById("pName");
    const price = document.getElementById("pPrice");
    const activities = document.getElementById("pActivities");

    if (type === 'ella') {
        name.innerText = "Ella Mist Adventure";
        price.innerText = "Rs 36,000";
        activities.innerHTML = `
            <li>You can hike Little Adam's Peak for the view</li>
            <li>You can explore the Nine Arch Bridge history</li>
            <li>You can climb Ella Rock for a challenge</li>
            <li>You can relax at Ravana Falls</li>
        `;
    }
}

function closePanel() {
    document.getElementById("sidePanel").style.width = "0"; // Panel එක ඇතුළට යනවා
}