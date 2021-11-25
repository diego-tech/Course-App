<h1>App de Cursos</h1>

API realizada con Laravel para una aplicación de cursos con los siguientes requisitos:

1. Los usuarios podrán registrarse con nombre, foto, email y contraseña. El email no se puede repetir entre varios usuarios.
2. Se debe poder editar la información de los usuarios, excepto el email. Debe existir una opción para desactivar los usuarios, ya que no se pueden borrar completamente.
3. Debemos poder dar de alta cursos. Un curso tiene un título, una descripción y una foto. Por cada curso se deben poder asociar una serie de vídeos, que tendrán título, foto de portada y enlace al vídeo.
4. Debe existir la opción de listar todos los cursos que tenemos registrados. El listado muestra los títulos de los cursos, su foto y la cantidad total de vídeos que tiene. Este listado es filtrable por títulos (obteniendo todos aquellos en cuyo título aparezca la palabra buscada).
5. Los usuarios podrán adquirir cursos. Cuando se registre esta solicitud de adquisición, el curso queda asociado al usuario de forma indefinida.
6. Los usuarios deberán poder ver un listado de cursos específico que muestre únicamente aquellos que han adquirido.
7. Los usuarios pueden obtener el listado de vídeos de un curso, con su nombre y foto, y un indicador de si ya ha visto el vídeo o no. Esta información solo estará disponible si han adquirido el curso previamente. Cualquier intento de obtener estos datos sin haber comprado el curso debe devolver un error.
8. Si un usuario tiene un curso adquirido, entonces podrá realizar peticiones para ver los vídeos obteniendo su ID y enlace. Cuando esta petición se realiza, el vídeo queda registrado como "visto" para ese usuario.

Develop by Diego Muñoz Herranz | <a href="https://www.dmunoz.dev/" target="_blank">dmunoz.dev</a> | <a href="https://www.linkedin.com/in/diego-mu%C3%B1oz-herranz-b03a42182/" target="_blank"> Linkedin</a>
