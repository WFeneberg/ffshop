 //showHome();
 function updatemenu() {
    if (document.getElementById('responsive-menu').checked) {
      document.getElementById('menu').style.borderBottomRightRadius = '0';
      document.getElementById('menu').style.borderBottomLeftRadius = '0';
    } else {
      document.getElementById('menu').style.borderRadius = '10px';
    }
  }

  function showHome() {
    hideAll();
    document.getElementById('home').style.display = 'block';
  }

  function showKonto() {
    hideAll();
    document.getElementById('konto').style.display = 'block';
  }

  function showWarenkorb() {
    hideAll();
    document.getElementById('warenkorb').style.display = 'block';
  }

  function showLogin() {
    hideAll();
    document.getElementById('login').style.display = 'block';
  }

  function showAdmin() {
    hideAll();
    document.getElementById('admin').style.display = 'block';
  }

  function hideAll() {
    var sections = document.querySelectorAll('#content > div');
    sections.forEach(function(section) {
      section.style.display = 'none';
    });
  }

  function login(event) {
    event.preventDefault();
    // Hier können Sie die Authentifizierung hinzufügen
    // Wenn erfolgreich, wird die Anmeldeseite ausgeblendet und die Home-Seite sowie das Menü angezeigt
    document.getElementById('login').style.display = 'none';
    document.getElementById('menu').style.display = 'block';
    document.getElementById('content').style.display = 'block';
    showHome();
  }