function addFilterByRoleEvent(){
    const selectElement = document.getElementById("roleFilter");

    selectElement.addEventListener("change", function() {
        filterByRole(selectElement.value);
    });
}

function filterByRole(role) {
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
    addHoldEventListeners();
    addFilterByRoleEvent();
}

function addFilterByStatusEvent(){
    const selectElement = document.getElementById("statusFilter");

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
    addHoldEventListeners();
    addFilterByRoleEvent();
}