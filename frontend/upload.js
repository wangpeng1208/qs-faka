// npm install ssh2-sftp-client --save-dev

// 计划中的一个sftp安装办法
// const Client = require('ssh2-sftp-client');
// const sftp = new Client();

// async function main() {
//   await sftp.connect({
//     host: 'yourserver.com',
//     username: 'user',
//     password: 'password'
//   });
//   await sftp.uploadDir('dist', '/path/to/your/project');
//   await sftp.end();
// }

// main().catch(console.error);


// {
//     "scripts": {
//       "build": "vue-tsc --noEmit && vite build --mode release && node upload.js"
//     }
//   }