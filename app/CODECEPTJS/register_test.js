Feature('register');
Scenario('Register', ({ I }) => {
  I.amOnPage('http://localhost:8000/login');
  I.fillField('#email','feliciaryu33@gmail.com');
  I.fillField('#password', '1111');
  I.click('#login');
  I.seeInCurrentUrl('/adminPostList');
  I.click('#createUser'); 
  I.seeInCurrentUrl('http://localhost:8000/register'); 
  I.fillField('input[name="name"]', 'Htet Htet'); 
  I.fillField('input[name="email"]', 'htethtetyannaing33@gmail.com'); 
  I.fillField('input[name="pw"]', 'password123'); 
  I.fillField('input[name="pw_confirmation"]', 'password123'); 
  I.attachFile('input[name="profile"]', 'image/profile.png'); 
  I.click('#register');
  I.seeInCurrentUrl('http://localhost:8000/confirmRegister'); 
  I.click('#confirm'); 
  I.seeInCurrentUrl('http://localhost:8000/admin/userList'); 
  I.waitForText('Users'); 
});