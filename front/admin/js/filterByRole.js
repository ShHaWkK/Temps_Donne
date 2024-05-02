function addFilterByRoleEvent(users){
    const selectElement = document.getElementById("roleFilter");

    console.log("On entre dans filterByRoleEvent");
    selectElement.addEventListener("change", function() {
        filterByRole(selectElement.value,users);
    });
}

function filterByRole(role,users) {
    console.log("On entre dans filterByRole");
    console.log("users",users)
    if (role === 'all') {
        getAllUsers();
        addApproveEventListeners();
        addFilterByRoleEvent(users);
    } else {
        const filteredUsers = users.filter(user => user.Role === role);
        displayUsers(filteredUsers);
        addApproveEventListeners();
        addFilterByRoleEvent(filteredUsers);
    }
}