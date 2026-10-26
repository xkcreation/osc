const fs = require('fs');
const file1 = "page.txt";
const data = `
Employee Name: 'pavithra',
Employee ID: '001'
`;

// Create and write the file
fs.writeFile(file1, data, function (err) {
  if (err) {
    console.log(err);
  } else {
    console.log("File created");
  }

  // Read the file
  fs.readFile(file1, (err, content) => {
    if (err) {
      console.log(err);
    } else {
      console.log(content.toString());
    }
  });
});
