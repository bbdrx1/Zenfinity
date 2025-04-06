function showSuccessPopup(username) {
  document.getElementById('popupUsername').textContent = username;
  document.getElementById('successPopup').style.display = 'block';
  document.querySelector('.overlay').style.display = 'block';

  
  setTimeout(function() {
    window.location = 'HomePage.php';
  }, 3000); 
}

function showErrorPopup() {
  document.getElementById('errorPopup').style.display = 'block';
  document.querySelector('.overlay').style.display = 'block';
}

function closePopup() {
  document.getElementById('successPopup').style.display = 'none';
  document.getElementById('errorPopup').style.display = 'none';
  document.querySelector('.overlay').style.display = 'none';
}

document.querySelector('form').addEventListener('submit', function(event) {
  event.preventDefault();

  var username = document.getElementById('username').value;
  var password = document.getElementById('password').value;

  fetch('process.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password)
  })
    .then(function(response) {
      if (response.ok) {
        return response.text();
      } else {
        throw new Error('Network response was not ok');
      }
    })
    .then(function(result) {
      if (result === 'success') {
        showSuccessPopup(username);
      } else {
        showErrorPopup();
      }
    })
    .catch(function(error) {
      console.error('Error:', error);
    });
});

document.querySelectorAll('.popup .close-button').forEach(function(button) {
  button.addEventListener('click', function(event) {
    event.preventDefault();
    closePopup();
  });
});

document.querySelector('.overlay').addEventListener('click', function(event) {
  event.preventDefault();
  closePopup();
});