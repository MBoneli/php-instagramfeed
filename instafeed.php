<!-- ===============================================================================================================
* Instagram Feed PHP Montage
* Por: Matheus Boneli									
* Em: 19/09/2018
* Versão: 1.7.0 => Att: Agora o CSS é integrado a API // Now the css is incorporated with the API
*
* 1- Para usar, dê um require no arquivo instafeed.php e usar "echo" na função instafeed();.
* 2- É possível fazer mais modificações, como buscar imagens por Hashtag, mas é preciso mais tempo, tavez conforme necessidade isso seja implantado.
*
* 1- To use, do a require in the archive instafeed.php and use "echo" in the function instafeed();
* 2- It's possible a lot more modifications,  like search images for hashtag, but need more time, maybe with the necessity that will be implant.
*
* Exemplo/Exemple: 
* <?php //require instafeed.php  ?>
* <?php //echo instafeed() ?>
================================================================================================================= -->
<style>

.box-insta {
    border: 1px solid #E1E1E1;
}

.insta-avatar {
    display: inline-block;
    padding: 10px;
}

.insta-avatar img {
    width: 30px;
    border-radius: 50%;
    display: block;
}

.insta-avatar img:hover {
    opacity: .5;
}

small.localizacao a {
	display: block;
    font-size: 95%;
    position: relative;
    bottom: 0.5rem;
    left: 0.5rem;
    color: #262626;
    font-weight: 100;
}

small.localizacao a:hover {
	text-decoration: underline;
}

.visualizar-perfil a span {
	
}

.visualizar-perfil {
    background-color: #3897f0;
    color: #fff;
    border-radius: 3px;
    display: inline-block;
    -webkit-flex-shrink: 0;
    -ms-flex-negative: 0;
    flex-shrink: 0;
    font-weight: 600;
    margin-left: auto;
    padding: 5px 12px;
    float: right;
    text-decoration: none;
    top: 1rem;
    position: relative;
    right: 1rem;
    border: none;
}
    
.visualizar-perfil:hover, .visualizar-perfil:focus  {
    background-color: #003569;
    color: #fff;
}

.username {
    color: #262626;
    display: inline-block;
    font-weight: bold;
	position: absolute;
}

.username span a {
    color: #262626;
    display: inline-block;
    text-decoration: none;
    padding: 5px;
    position: relative;
}

.username span a:hover {
    text-decoration: underline;
}

.insta-box {
    padding: 10px;
}

hr {
    margin: 5px;
}

span.username-baixo a {
    font-weight: bolder;
    color: #262626;
    display: inline-block;
}

span.username-baixo a:hover {
    text-decoration: underline;
}

p.insta-coments a {
    color: #999;
    padding: 10px 0px 0px 5px;
    position: relative;
    top: 1rem;
}

.insta-coments:hover {
    text-decoration: underline;
}

p.likes a {
    font-weight: bolder;
    color: #262626;
    display: flex;
    padding-left: 5px;
    margin: 0;
    font-size: 12px;
}

p.likes a:hover {
    text-decoration: underline;
}

p.insta-caption {
    display: unset;
}

p.insta-caption a {
    color: #000000;
}
</style>

<?php


function instafeed()

{
	
	// Variáveis de Autenticação. 
	// Para gerar um Token de acesso, utilize o site: (http://instagram.pixelunion.net/). O UserID são os primeiros números antes do primeiro "." (Ponto).
	// A variável Count dá a quantidade de posts que deve retornar, do perfil escolhido (Você pode usar um Foreach para pegar multiplos posts).
	// Instalink é a URL do perfil no Instagram (Deve ser configurada na Index).
	// Instastories é a URL de Stories do perfil no Instagram (Deve ser configurada na Index).
	// 
	// Authentication variables.
	// To get your Access Token, use the website: (http://instagram.pixelunion.net/). The UserID are the first numbers before the first "." (dot).
	// The Count variable gives the number of posts in the chosen profile (You can do a Foreach to catch multiple posts).
	// Instalink is the Profile URL in the Instagram (Needs to be defined in Index).
	// Instastories is the Stories URL Profile in the Instagram (Needs to be defined in Index).
	
	$userID = '4370978057';
	$accessToken = '4370978057.1677ed0.f83379765b06432b9793581b96849dbb';
	$count = 1;
	$instalink = CLIENTE_INSTAGRAM;	
	$instastories = CLIENTE_INSTAGRAM_STORIES;
	
	// Usando o Curl para solicitar os dados do instagram
	// 
	// Using Curl to fetch the data from instagram
	
	function fetchData($url)
	
	{
	
		  $curl = curl_init();
		  curl_setopt($curl, CURLOPT_URL, $url);
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($curl, CURLOPT_TIMEOUT, 20);
		  $result = curl_exec($curl);
		  curl_close($curl); 
		  return $result;
	
	}
	
	// Decodifica os dados solicitados
	// tags, location, comments, filter, created_time, link, likes, imagens[low_res, thumbnail, standard_res], usuários na foto
	//
	// Decode fetched data
	// tags, location, comments, filter, created_time, link, likes, images[low_res, thumbnail, standard_res], users in photo
	
	$instafeed = fetchData('https://api.instagram.com/v1/users/' . $userID .  '/media/recent/?access_token=' . $accessToken . '&count=' . $count );
	$instafeed = json_decode($instafeed);
	
	
	// Monta Array com dados
	// 
	// Build data array 
	
	$photos = array(); 
	
	
$ig = $instafeed->data[0];

		echo ' 
		<div class="box-insta">
			<div class="insta-header">
				<div class="insta-avatar">
					<a href="' . $instastories . '" target="_blank"><img src="' . $ig->user->profile_picture . '" alt="Avatar '. $ig->user->username .'"></a> 
				</div>

				<div class="username">
					<span><a href="' . $instalink . '" target="_blank">' . $ig->user->username . '</a></span>
					<small class="localizacao"><a href="'. (empty($ig->location->id) ? '' : 'https://www.instagram.com/explore/locations/' . $ig->location->id) .'" target="_blank">'. (empty($ig->location->name) ? '' : $ig->location->name) .'</a></small>
				</div>

					<a class="visualizar-perfil" href="' . $instalink . '" target="_blank">
						<span> Visualizar Perfil</span>
					</a>
					
				
			</div>

			<a class="ig-photo" target="_blank" href="' . $ig->link . '">
				<img src="' . $ig->images->standard_resolution->url . '" alt="' . $ig->caption->text . '" /> 
			</a>
				<hr>

				<div class="insta-box">
				<p class="likes"><a href="' . $ig->link . '" target="_blank">' . $ig->likes->count . ' curtidas</a></p>
				<span class="username-baixo"><a href="'.$instalink.'" target="_blank">' . $ig->user->username . '</a></span>
				<p class="insta-caption"><a href="' . $ig->link . '" target="_blank">' . $ig->caption->text . '</a></p>
				<p class="insta-coments"><a href="' . $ig->link . '" target="_blank">Visualize os ' . $ig->comments->count . ' comentários</a></p>
				</div>
		</div>
			';

}