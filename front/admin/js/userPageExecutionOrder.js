// Initialisation
window.onload = function() {
    checkSessionVolunteer()
        .then(() => {
            return getAllUsers();
        })
        .then(users => {
            allUsers = users;
            displayedUsers=users;
            console.log(allUsers);
            displayUsers(allUsers);
        })
        .then(() => {
            addFilterByRoleEvent();
        })
        .then(() => {
            addFilterByStatusEvent();
        })
        .then(() => {
            addApproveEventListeners();
            addHoldEventListeners();
            addRejectEventListeners();
        })
        .then(()=>{
            addRejectModalEventListeners();
            addUserDetailsModalEventListeners();
            addAddUserEvent();
            addSelectedButtonEvent();
        })
        .catch(error => {
            console.error("Une erreur s'est produite :", error);
        });
}