# RC7 - QuarkChat
<h1> Trabalho final do modulo 7 de Redes de Comunicação </h1>





para executar o projeto é necesario:
<ul>

<li>
<a href="https://www.apachefriends.org">Xamp | Servidor PHP<a/>
</li>
<li>
<a href="https://nodejs.org/en/"> Node | Servidor JS<a/>
</li>
<li>
<a href="https://classic.yarnpkg.com/lang/en/docs/install/#windows-stable">Yarn | Gestor de pacotes<a/> 
<a href="https://www.youtube.com/watch?v=Ps17izoF5pc">Video tutorial para instalar o Yarn </a>
</li>
</ul>
<p> Apos clonar o repositorio, vá até o Diretório  /src e no console do VScode digite: </p>

```bash

yarn 

``` 
<p>esse comando ira instalar todas as dependencias do projeto </p>
<p>Logo a seguir será possivel iniciar o servidor node com o comando: </p>

```bash

yarn dev

``` 
<p>Vale lembrar que também é importante iniciar o serviço Apache e MySql no Xampp </p>
<p>Também é importante verificar se as portas condizem com as do ficheiro conn.php </p>

<p>Para criar a base de dados basta ir ate src/backend/createdb.php que a base de dados será criada </p>

<p>Agora só basta criar uma conta e realizar o login para utilizar a applicação web </p>

<h3><strong>ATENÇÃO!!!</strong></h3>

<p>as vezes o CORS não permite que o front end comunique com o back end </p>
<p>para resolver esse problema basta ir  ate as definições do Apache em httpd.conf  e colar as seguintes definições abaixo de "listen 80"</p>

```bash
Header set Access-Control-Allow-Origin "*" 
Header set Access-Control-Allow-Methods "GET, POST, PUT, DELETE, OPTIONS"
Header set Access-Control-Allow-Headers "X-Requested-With, Content-Type, X-Token-Auth, Authorization"

``` 

<p>Isso deve resolver.</p>




<h1> Navegação no site <h1>

![image](https://user-images.githubusercontent.com/74683757/213816773-351999d3-6059-4994-acf4-c52b2b19111b.png)

<p>Menu inicial</p>

<br/>


<div>

![image](https://user-images.githubusercontent.com/74683757/213817006-cbff0e74-be99-49b0-8b45-44955e95f892.png)
</div>

<p>Menu de registro</p>
<br/>


<div>

![image](https://user-images.githubusercontent.com/74683757/213817438-5f8b3932-76a3-4c15-9f56-1464e9b18757.png)

</div>

<p>Menu de login </p>

<br/>


<div>

![image](https://user-images.githubusercontent.com/74683757/213818353-cbdbda9d-082b-4ef4-8f45-2c7b4b831717.png)

</div>

<p> Página princiapal </p>
<br/>


<div>

![image](https://user-images.githubusercontent.com/74683757/213818683-93c3a6b1-ef25-44a8-92d9-80fc4db962a0.png)
</div>

<p>Menu de alteração de credenciais</p>
