(function($) {

	$.fn.videoPlayer = function(options) { //nm plugin


		var settings = {
			playerWidth : '0.95', // par defaut 95%
			videoClass : 'video'
		}

		// Fusionne les options pour qu'elles soient prises en compte par le plugin
		if(options) {
			$.extend(settings, options);
		}


		// each pour chainage
		return this.each(function() {

			$(this)[0].addEventListener('loadedmetadata', function() {

				// variable
				var $this = $(this);
				var $settings = settings;

				// Entourer la balise <video> d'une balise <div> ayant la classe CSS précisée en option
				$this.wrap('<div class="'+$settings.videoClass+'"></div>');


				// Sélectionner la div contenant la vidéo pour faciliter son utilisation
				var $that = $this.parent('.'+$settings.videoClass);

				// structure du lecteur
				{

				$( '<div class="player">'
				     + '<div class="play-pause play">'
				       + '<span class="play-button">&#9658;</span>'
				       + '<div class="pause-button">'
				         + '<span> </span>'
					         + '<span> </span>'
				       + '</div>'
				     + '</div>'
				     + '<div class="progress">'
				       + '<div class="progress-bar">'
				         + '<div class="button-holder">'
				           + '<div class="progress-button"> </div>'
				         + '</div>'
				       + '</div>'
				       + '<div class="time">'
				         + '<span class="ctime">00:00</span>'
				         + '<span class="stime"> / </span>'
				         + '<span class="ttime">00:00</span>'
				       + '</div>'
				     + '</div>'
				     + '<div class="volume">'
				       + '<div class="volume-holder">'
				         + '<div class="volume-bar-holder">'
				           + '<div class="volume-bar">'
				             + '<div class="volume-button-holder">'
				               + '<div class="volume-button"> </div>'
				             + '</div>'
				           + '</div>'
				         + '</div>'
				       + '</div>'
				       + '<div class="volume-icon v-change-0">'
				         + '<span> </span>'
				       + '</div>'
				     + '</div>'
				     + '<div class="fullscreen"> '
				       + '<a href="#"> </a>'
				     + '</div>'
				   + '</div>').appendTo($that);

				}


				// Ajuste de la largeur de la vidéo
				$videoWidth = $this.width();
				$that.width($videoWidth+'px');

				// Ajustement de la largeur du lecteur en fonction des options
				$that.find('.player').css({'width' : ($settings.playerWidth*100)+'%', 'left' : ((100-$settings.playerWidth*100)/2)+'%'});


				// info sur la video
				var $spc = $(this)[0],
					$duration = $spc.duration, // durée
					$volume = $spc.volume, // volume
					currentTime;

				// etat du lecteur
				var $mclicking = false,
				    $vclicking = false,
				    $vidhover = false,
				    $volhover = false,
				    $playing = false,
				    $drop = false,
				    $begin = false,
				    $draggingProgess = false,
				    $storevol,
				    x = 0,
				    y = 0,
				    vtime = 0,
				    updProgWidth = 0,
				    volume = 0;

				var $volume = $spc.volume;

				//le user ne peut pas selectionner de texte dans le lecteur
				$that.bind('selectstart', function() { return false; });

				// Largeur de la barre de progression
				var progWidth = $that.find('.progress').width();


				var bufferLength = function() {

					// Les parties de la vidéo en tampon
					var buffered = $spc.buffered;

					// Réinitialiser les zones en tampon à chaque appel de la fonction
					$that.find('[class^=buffered]').remove();

					// If buffered regions exist

					if(buffered.length > 0) {

						// On affecte sa taille à i
						var i = buffered.length;

						while(i--) {
							$maxBuffer = buffered.end(i);
							$minBuffer = buffered.start(i);

							// Le décalage et la largeur de la partie en tampon
							var bufferOffset = ($minBuffer / $duration) * 100;
							var bufferWidth = (($maxBuffer - $minBuffer) / $duration) * 100;

							// Insérer la zone en tampon dans le lecteur
							$('<div class="buffered"></div>').css({"left" : bufferOffset+'%', 'width' : bufferWidth+'%'}).appendTo($that.find('.progress'));

						}
					}
				}

				// Lancer la fonction de gestion du tampon
				bufferLength();

				// La fonction de gestion du temps, met à jour le compteur
				var timeUpdate = function($ignore) {

					// Le temps actuel de la vidéo, basé sur la barre de progression
					var time = Math.round(($('.progress-bar').width() / progWidth) * $duration);

					// Le temps de la vidéo
					var curTime = $spc.currentTime;

					// Les secondes sont initialisées à 0 par défaut, les minutes correspondent à la durée divisée par 60
    			// tminutes et tseconds sont les minutes et secondes totales
					var seconds = 0,
						minutes = Math.floor(time / 60),
						tminutes = Math.round($duration / 60),
						tseconds = Math.round(($duration) - (tminutes*60));

					if(time) {
						// Les secondes valent la durée moins les minutes
						seconds = Math.round(time) - (60*minutes);

						if(seconds > 59) {
							// On augmente les minutes et on soustrait les secondes en trop
							seconds = Math.round(time) - (60*minutes);
							if(seconds == 60) {
								minutes = Math.round(time / 60);
								seconds = 0;
							}
						}

					}

					// Mise à jour de la barre de progression
					updProgWidth = (curTime / $duration) * progWidth

					// Ajout des zéros initiaux pour les valeurs inférieures à 10
					if(seconds < 10) { seconds = '0'+seconds; }
					if(tseconds < 10) { tseconds = '0'+tseconds; }

					if($ignore != true) {
						$that.find('.progress-bar').css({'width' : updProgWidth+'px'});
						$that.find('.progress-button').css({'left' : (updProgWidth-$that.find('.progress-button').width())+'px'});
					}

					// Ajustement des durées
					$that.find('.ctime').html(minutes+':'+seconds)
					$that.find('.ttime').html(tminutes+':'+tseconds);

					// En mode lecture, mise à jour des valeurs du tampon
					if($spc.currentTime > 0 && $spc.paused == false && $spc.ended == false) {
						bufferLength();
					}

				}

				// Lancer la fonction de temps au démarrage puis à chaque événement lié
				timeUpdate();
				$spc.addEventListener('timeupdate', timeUpdate);

				// Lorsque l'utilisateur clique sur lecture, générer un événement clic
				$that.find('.play-pause').bind('click', function() {

					// Affectation d'une variable de lecture
					if($spc.currentTime > 0 && $spc.paused == false && $spc.ended == false) {
						$playing = false;
					} else { $playing = true; }

					// Modifier les classes CSS pour afficher le bouton lecture ou pause
					if($playing == false) {
						$spc.pause();
						$(this).addClass('play').removeClass('pause');
						bufferLength();
					} else {
						$begin = true;
						$spc.play();
						$(this).addClass('pause').removeClass('play');
					}

				});


				// Affecter un événement sur la barre de progression pour que
				//l'utilisateur puisse choisir un point précis de la vidéo
				$that.find('.progress').bind('mousedown', function(e) {

					// Lorsque l'on clique sur la barre
					$mclicking = true;

					// Si la vidéo est en cours de lecture, on met en pause
					if($playing == true) {
						$spc.pause();
					}

					// Position x de la souris lors du clic
					x = e.pageX - $that.find('.progress').offset().left;

					// Mise à jour du temps actuel
					currentTime = (x / progWidth) * $duration;

					$spc.currentTime = currentTime;

				});

				// Si l'on clique sur le volume, déclencher un événement de changement de volume
				$that.find('.volume-bar-holder').bind('mousedown', function(e) {

					// On a cliqué sur le volume
					$vclicking = true;

					// Position y de la souris sur le slider
					y = $that.find('.volume-bar-holder').height() - (e.pageY - $that.find('.volume-bar-holder').offset().top);

					// On annule (return false) si le clic se fait en dehors de la zone autorisée
					if(y < 0 || y > $(this).height()) {
						$vclicking = false;
						return false;
					}

					// Ajustement des CSS pour refléter les modifications
					$that.find('.volume-bar').css({'height' : y+'px'});
					$that.find('.volume-button').css({'top' : (y-($that.find('.volume-button').height()/2))+'px'});

					$spc.volume = $that.find('.volume-bar').height() / $(this).height();
					$storevol = $that.find('.volume-bar').height() / $(this).height();
					$volume = $that.find('.volume-bar').height() / $(this).height();

					// Animation de l'icône de volume
					volanim();

				});

				// Gestion de l'animation de l'icône de volume
				var volanim = function() {

					//Ajuster les classes CSS en fonction de la valeur du volume.
					for(var i = 0; i < 1; i += 0.1) {

						var fi = parseInt(Math.floor(i*10)) / 10;
						var volid = (fi * 10)+1;

						if($volume == 1) {
							if($volhover == true) {
								$that.find('.volume-icon').removeClass().addClass('volume-icon volume-icon-hover v-change-11');
							} else {
								$that.find('.volume-icon').removeClass().addClass('volume-icon v-change-11');
							}
						}
						else if($volume == 0) {
							if($volhover == true) {
								$that.find('.volume-icon').removeClass().addClass('volume-icon volume-icon-hover v-change-1');
							} else {
								$that.find('.volume-icon').removeClass().addClass('volume-icon v-change-1');
							}
						}
						else if($volume > (fi-0.1) && volume < fi && !$that.find('.volume-icon').hasClass('v-change-'+volid)) {
							if($volhover == true) {
								$that.find('.volume-icon').removeClass().addClass('volume-icon volume-icon-hover v-change-'+volid);
							} else {
								$that.find('.volume-icon').removeClass().addClass('volume-icon v-change-'+volid);
							}
						}

					}
				}
				volanim();

				// Gestion du survol du bouton de volume
				$that.find('.volume').hover(function() {
					$volhover = true;
				}, function() {
					$volhover = false;
				});

				$('body, html').bind('mousemove', function(e) {

					 // Masquer le lecteur si la lecture est en cours et que la souris quitte la vidéo
					if($begin == true) {
						$that.hover(function() {
							$that.find('.player').stop(true, false).animate({'opacity' : '1'}, 0.5);
						}, function() {
							$that.find('.player').stop(true, false).animate({'opacity' : '0'}, 0.5);
						});
					}

					// Contrôle de la barre de progression
					if($mclicking == true) {

						// Déplacement de la souris
						$draggingProgress = true;
						var progMove = 0;
						// Largeur du bouton de progression (le bouton au bout de la barre)
						var buttonWidth = $that.find('.progress-button').width();

						// La position de la souris détermine la valeur de x
						x = e.pageX - $that.find('.progress').offset().left;

						// Si la lecture est en cours
						if($playing == true) {
							// et que le temps actuel est inférieur à la durée
							if(currentTime < $duration) {
								 // alors le bouton lecture/pause doit être sur pause
								$that.find('.play-pause').addClass('pause').removeClass('play');
							}
						}


						if(x < 0) { // Si x est inférieur à zéro, la barre de progression reste à zéro
							progMove = 0;
							$spc.currentTime = 0;
						}
						else if(x > progWidth) { // Si x est supérieur à la largeur de la barre, alors progMove vaut progWidth
							$spc.currentTime = $duration;
							progMove = progWidth;
						}
						else { // Sinon, progMove vaut x
							progMove = x;
							currentTime = (x / progWidth) * $duration;
							$spc.currentTime = currentTime;
						}

						// Changement de CSS en fonction des conditions précédentes
						$that.find('.progress-bar').css({'width' : $progMove+'px'});
						$that.find('.progress-button').css({'left' : ($progMove-buttonWidth)+'px'});

					}

					// Contrôle du volume
					if($vclicking == true) {

						 // Position de la souris sur le slider
						y = $that.find('.volume-bar-holder').height() - (e.pageY - $that.find('.volume-bar-holder').offset().top);

						var volMove = 0;

						 // Si la boîte contenant le contrôle du volume est masquée, on ne fait rien
						if($that.find('.volume-holder').css('display') == 'none') {
							$vclicking = false;
							return false;
						}

						// Ajout de la classe correspondant au survol
						if(!$that.find('.volume-icon').hasClass('volume-icon-hover')) {
							$that.find('.volume-icon').addClass('volume-icon-hover');
						}


						if(y < 0 || y == 0) {

							$volume = 0;
							volMove = 0;

							$that.find('.volume-icon').removeClass().addClass('volume-icon volume-icon-hover v-change-11');

						} else if(y > $(this).find('.volume-bar-holder').height() || (y / $that.find('.volume-bar-holder').height()) == 1) {

							$volume = 1;
							volMove = $that.find('.volume-bar-holder').height();

							$that.find('.volume-icon').removeClass().addClass('volume-icon volume-icon-hover v-change-1');

						} else {

							$volume = $that.find('.volume-bar').height() / $that.find('.volume-bar-holder').height();
							volMove = y;

						}

						 // Changement de CSS en fonction des conditions précédentes
						$that.find('.volume-bar').css({'height' : volMove+'px'});
						$that.find('.volume-button').css({'top' : (volMove+$that.find('.volume-button').height())+'px'});

						 // Lancer l'animation
						volanim();

						// Change et stocke le volume
        		// La valeur stockée correspond à la valeur choisie par l'utilisateur
        		// s'il veut couper le son, alors il retrouvera la dernière valeur s'il le remet
						$spc.volume = $volume;
						$storevol = $volume;


					}

					// Lors du survol de la barre de volume, faire apparaitre/disparaitre
					//et modifier la classe CSS

					if($volhover == false) {

						$that.find('.volume-holder').stop(true, false).fadeOut(100);
						$that.find('.volume-icon').removeClass('volume-icon-hover');

					}

					else {
						$that.find('.volume-icon').addClass('volume-icon-hover');
						$that.find('.volume-holder').fadeIn(100);
					}


				})

				// À la fin de la lecture, le bouton lecture devient un bouton pause
				$spc.addEventListener('ended', function() {

					$playing = false;

					// S'il n'y a pas de déplacement du curseur
					if($draggingProgress == false) {
						$that.find('.play-pause').addClass('play').removeClass('pause');
					}

				});

				// Si l'utilisateur clique sur l'icône de volume, on coupe le son et on stocke la valeur du volume
				// lorsque l'on réactive le son, on lui affecte le volume stocké
				$that.find('.volume-icon').bind('mousedown', function() {

					$volume = $spc.volume; // Update volume

					// Si besoin, on initialise la mémorisation du volume
					if(typeof $storevol == 'undefined') {
						 $storevol = $spc.volume;
					}

					if($volume > 0) {
						// alors il faut couper le son, le volume passe alors à zéro
						$spc.volume = 0;
						$volume = 0;
						$that.find('.volume-bar').css({'height' : '0'});
						volanim();
					}
					else {
						 // sinon, on veut réactiver le son, on affecte au volume la valeur stockée
						$spc.volume = $storevol;
						$volume = $storevol;
						$that.find('.volume-bar').css({'height' : ($storevol*100)+'%'});
						volanim();
					}


				});


				// Lorsque le bouton est relâché, clicking vaut false pour le volume volume et la barre de progression
				// on relance la vidéo si elle était en lecture avant le déplacement du curseur
				$('body, html').bind('mouseup', function(e) {

					$mclicking = false;
					$vclicking = false;
					$draggingProgress = false;

					if($playing == true) {
						$spc.play();
					}

					bufferLength();


				});

				// Vérifie le support du mode plein écran. Si ce mode n'est pas supporté, le bouton n'est pas affiché
				if(!$spc.requestFullscreen && !$spc.mozRequestFullScreen && !$spc.webkitRequestFullScreen) {
					$('.fullscreen').hide();
				}

				$('.fullscreen').click(function() {

					if ($spc.requestFullscreen) {
						$spc.requestFullscreen();
					}

					else if ($spc.mozRequestFullScreen) {
						$spc.mozRequestFullScreen();
					}

					else if ($spc.webkitRequestFullScreen) {
						$spc.webkitRequestFullScreen();
					}

				});



			});

		});

	}

})(jQuery);
