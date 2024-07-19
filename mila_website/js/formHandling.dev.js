"use strict";

// formHandling.js
document.getElementById('contactForm').addEventListener('submit', function (event) {
  event.preventDefault(); // Empêche le formulaire de se soumettre de manière classique

  var form = event.target;
  var formData = new FormData(form);
  grecaptcha.ready(function () {
    grecaptcha.execute('6LeSKBMqAAAAAHMEHn_LL93ByuRv6VRSR56kvZj1', {
      action: 'submit'
    }).then(function (token) {
      formData.append('recaptcha_token', token);
      var xhr = new XMLHttpRequest();
      xhr.open('POST', form.action, true);

      xhr.onload = function () {
        if (xhr.status === 200) {
          try {
            var response = JSON.parse(xhr.responseText);
            console.log('Server Response:', response); // Log response

            if (response.status === 'success') {
              Swal.fire({
                title: 'Merci !',
                text: 'Votre message a été envoyé !',
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                  popup: 'my-popup-class',
                  title: 'my-title-class',
                  content: 'my-content-class',
                  confirmButton: 'my-confirm-button-class',
                  icon: 'my-icon-class'
                }
              });
              form.reset(); // Réinitialiser le formulaire après l'envoi réussi
            } else {
              Swal.fire({
                title: 'Erreur',
                text: response.message,
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                  popup: 'my-popup-class',
                  title: 'my-title-class',
                  content: 'my-content-class',
                  confirmButton: 'my-confirm-button-class',
                  icon: 'my-icon-class'
                }
              });
            }
          } catch (e) {
            console.error('Erreur lors de la lecture de la réponse JSON', e);
            Swal.fire({
              title: 'Erreur',
              text: 'Erreur lors de la lecture de la réponse du serveur.',
              icon: 'error',
              confirmButtonText: 'OK',
              customClass: {
                popup: 'my-popup-class',
                title: 'my-title-class',
                content: 'my-content-class',
                confirmButton: 'my-confirm-button-class',
                icon: 'my-icon-class'
              }
            });
          }
        } else {
          console.error('Erreur lors de la requête AJAX');
          Swal.fire({
            title: 'Erreur',
            text: 'Erreur lors de la requête AJAX.',
            icon: 'error',
            confirmButtonText: 'OK',
            customClass: {
              popup: 'my-popup-class',
              title: 'my-title-class',
              content: 'my-content-class',
              confirmButton: 'my-confirm-button-class',
              icon: 'my-icon-class'
            }
          });
        }
      };

      xhr.send(new URLSearchParams(formData));
    });
  });
});
document.getElementById('newsletterForm').addEventListener('submit', function (event) {
  event.preventDefault(); // Empêche le formulaire de se soumettre de manière classique

  var form = event.target;
  var formData = new FormData(form);
  var xhr = new XMLHttpRequest();
  xhr.open('POST', form.action, true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      try {
        var response = JSON.parse(xhr.responseText);

        if (response.status === 'success') {
          Swal.fire({
            title: 'Inscription réussie!',
            text: 'Merci pour votre inscription à notre newsletter.',
            icon: 'success',
            confirmButtonText: 'OK',
            customClass: {
              popup: 'my-popup-class',
              title: 'my-title-class',
              content: 'my-content-class',
              confirmButton: 'my-confirm-button-class',
              icon: 'my-icon-class'
            }
          });
          form.reset(); // Réinitialiser le formulaire après l'envoi réussi
        } else {
          Swal.fire({
            title: 'Erreur',
            text: response.message,
            icon: 'error',
            confirmButtonText: 'OK',
            customClass: {
              popup: 'my-popup-class',
              title: 'my-title-class',
              content: 'my-content-class',
              confirmButton: 'my-confirm-button-class',
              icon: 'my-icon-class'
            }
          });
        }
      } catch (e) {
        console.error('Erreur lors de la lecture de la réponse JSON', e);
        Swal.fire({
          title: 'Erreur',
          text: 'Erreur lors de la lecture de la réponse du serveur.',
          icon: 'error',
          confirmButtonText: 'OK',
          customClass: {
            popup: 'my-popup-class',
            title: 'my-title-class',
            content: 'my-content-class',
            confirmButton: 'my-confirm-button-class',
            icon: 'my-icon-class'
          }
        });
      }
    } else {
      console.error('Erreur lors de la requête AJAX');
      Swal.fire({
        title: 'Erreur',
        text: 'Erreur lors de la requête AJAX.',
        icon: 'error',
        confirmButtonText: 'OK',
        customClass: {
          popup: 'my-popup-class',
          title: 'my-title-class',
          content: 'my-content-class',
          confirmButton: 'my-confirm-button-class',
          icon: 'my-icon-class'
        }
      });
    }
  };

  xhr.send(new URLSearchParams(formData));
});
document.addEventListener('DOMContentLoaded', function () {
  var messageField = document.getElementById('message');
  var charCountDiv = document.getElementById('charCount');
  var maxLength = messageField.maxLength;

  function updateCharCount() {
    var currentLength = messageField.value.length;
    charCountDiv.textContent = "".concat(currentLength, " / ").concat(maxLength, " caract\xE8res");

    if (currentLength > maxLength) {
      charCountDiv.classList.add('maxLengthWarning');
    } else {
      charCountDiv.classList.remove('maxLengthWarning');
    }
  } // Met à jour le compteur à chaque frappe


  messageField.addEventListener('input', updateCharCount); // Initialise le compteur au chargement

  updateCharCount();
});