Feature('login');
Scenario('Login page testing',  ({ I }) => {
  I.amOnPage('http://localhost:8000/login');
  I.fillField('#email','feliciaryu33@gmail.com');
  I.fillField('#password', '1111');
  I.click('#login');
  I.seeInCurrentUrl('/adminPostList');
  I.see('Posts', '.nav-item'); 
  pause();
});


