<script type="text/javascript">
    //first_name last_name date_of_birth ssn drivers_license address apt_unit city state zipcode
function openConfirmedModal(user) {
    let name = document.getElementsByClassName('first_name')[0];
    let email = document.getElementsByClassName('email')[0];
    let user_id = document.getElementById('user_id');
    user_id.value = user.id;
    name.innerHTML = user.name;
    email.innerHTML = user.email;
}

</script>
