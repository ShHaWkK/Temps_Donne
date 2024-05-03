function addFilterByRoleEvent(){
    const selectElement = document.getElementById("roleFilter");

    console.log("On entre dans filterByRoleEvent");
    selectElement.addEventListener("change", function() {
        filterByRole(selectElement.value);
    });
}

function filterByRole(role) {
    console.log("On entre dans filterByRole");
    if (role === 'all') {
        console.log("All Users",allUsers)
        displayUsers(allUsers);
    } else {
        displayedUsers =allUsers.filter(user => user.Role === role);
        console.log("Displayed Users",displayedUsers)
        displayUsers(displayedUsers);
    }
    addApproveEventListeners();
    addRejectEventListeners();
    addFilterByRoleEvent();
}

function addFilterByStatusEvent(){
    const selectElement = document.getElementById("statusFilter");

    console.log("On entre dans filterByStatusEvent");
    selectElement.addEventListener("change", function() {
        filterByStatus(selectElement.value);
    });
}

function filterByStatus(status) {
    if (status === 'all') {
        console.log("All Users",allUsers)
        displayUsers(displayedUsers);
    } else {
        let statuedUsers = displayedUsers.filter(user => user.Statut === status);
        console.log("Displayed Users", displayedUsers)
        displayUsers(statuedUsers);
    }
    addApproveEventListeners();
    addRejectEventListeners();
    addFilterByRoleEvent();
}