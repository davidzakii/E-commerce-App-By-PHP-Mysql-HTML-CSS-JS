document.addEventListener('DOMContentLoaded', () => {
  //add li after li with id="lg-bag" to show userName
  const afterLgBag = document.getElementById('lg-bag');
  const liForUserName = document.createElement('li');
  //liForUserName.id = "liForUserName";
  liForUserName.classList.add('user-name');
  liForUserName.innerHTML = `
    <h4><?php echo $user['user_name'] ?></h4>
    <?php if(!empty($user['image'])){ ?>
    <img style="width: 50px;height: 50px;justify-content:center;align-items:center" src="./img/users/<?php  echo $user['image'] ?>" alt="">
    <?php } ?>
    `;
  afterLgBag.insertAdjacentElement('afterend', liForUserName);

  //creat icon when i clicked it will show select menu with  2 button
  //add li icon after liUserName
  const liForIcon = document.createElement('li');
  liForIcon.classList.add('drop-down-icon');
  liForIcon.innerHTML = `<i id="userIcon" class="fa-solid fa-caret-down"></i>`;
  liForUserName.insertAdjacentElement('afterend', liForIcon);
  //li for select
  const liForDropDownMenu = document.createElement('li');
  liForDropDownMenu.classList.add('li-for-drop-down-menu');
  const divForMenu = document.createElement('div');
  divForMenu.classList.add('div-for-menu');
  const btnUpdate = document.createElement('button');
  const btnSignOut = document.createElement('button');
  btnUpdate.textContent = 'Update Profile';
  btnSignOut.textContent = 'Sign Out';
  btnUpdate.id = 'updateProfile';
  btnSignOut.id = 'signOut';
  divForMenu.append(btnUpdate);
  divForMenu.appendChild(btnSignOut);
  // divForMenu.innerHTML = `
  // <button id="updateProfile">Update Profile</button>
  // <button id="signOut">Sign Out</button>
  // `;

  liForDropDownMenu.append(divForMenu);
  let selectVisible = false;

  liForIcon.addEventListener('click', () => {
    if (selectVisible) {
      // Hide select menu
      liForDropDownMenu.remove();
    } else {
      // Show select menu
      liForIcon.insertAdjacentElement('afterend', liForDropDownMenu);
    }
    // Toggle the state
    selectVisible = !selectVisible;
  });
  btnUpdate.addEventListener('click', function () {
    window.location.href =
      "profileUpdate.php?user_Id=<?php echo $user['user_Id']?>";
  });
  btnSignOut.addEventListener('click', function () {
    window.location.href = 'index.php';
  });
});
