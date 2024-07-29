Feature('upload');
Scenario('Upload page testing', ({ I }) => {
  I.amOnPage('http://localhost:8000/login');
  I.fillField('#email','feliciaryu33@gmail.com');
  I.fillField('#password', '1111');
  I.click('#login');
  I.seeInCurrentUrl('/adminPostList');
  I.click('#upload-btn');
  I.amOnPage('http://localhost:8000/posts/upload');
  I.attachFile('input[name="csvfile"]', 'image/profile.png'); 
  I.click('#upload');
  I.see('File must be csv type');
  I.wait(5);
});


