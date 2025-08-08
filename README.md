# Siroko Cart & Checkout API

API desacoplada para la gestión de carrito de compra y proceso de checkout.  
Arquitectura Hexagonal, DDD y CQRS, desarrollada sobre Symfony 7.


## 🚀 Tecnologías

- PHP 8.3+
- Symfony 7
- Doctrine ORM (opcional, actual persistencia in-memory)
- PHPUnit
- Docker + docker-compose


## 🧩 Modelado del dominio

El dominio está completamente desacoplado del framework y expone entidades y Value Objects como:
- **Cart**: Carrito de compra, contiene una colección de `CartItem`
- **CartItem**: ValueObject con `productId` y `quantity`
- **Order**: Orden generada al hacer checkout
- **OrderId/CartId**: ValueObjects para identificadores

Arquitectura CQRS:  
- Commands/Handlers para operaciones (add, update, remove, checkout)
- Queries/Handlers para lectura


## 🐳 Levantar entorno con Docker

```bash
docker-compose up -d
docker-compose exec php composer install
```

La API estará disponible en: [http://localhost:8080](http://localhost:8080)



## ✅ Ejecutar tests

```bash
docker-compose exec php vendor/bin/phpunit
```



## 🔌 OpenAPI Specification

Revisa el archivo [`openapi.yaml`](openapi.yaml).
Puedes visualizarlo en [Swagger Editor](https://editor.swagger.io/) o importarlo en Postman/Insomnia.



## 📚 Ejemplo de uso

### Añadir productos al carrito

```bash
curl -X POST http://localhost:8080/api/cart/abc/items \
  -H "Content-Type: application/json" \
  -d '{"productId":"sku1","quantity":1}'

curl -X POST http://localhost:8080/api/cart/abc/items \
  -H "Content-Type: application/json" \
  -d '{"productId":"sku2","quantity":2}'
```

### Listar productos del carrito

```bash
curl http://localhost:8080/api/cart/abc/items
```

### Modificar cantidad

```bash
curl -X PUT http://localhost:8080/api/cart/abc/items/sku1 \
  -H "Content-Type: application/json" \
  -d '{"quantity":5}'
```

### Eliminar producto

```bash
curl -X DELETE http://localhost:8080/api/cart/abc/items/sku2
```

### Checkout (crea una orden y vacía el carrito)

```bash
curl -X POST http://localhost:8080/api/cart/abc/checkout
```

### Listar órdenes generadas

```bash
curl http://localhost:8080/api/orders
```



## 🏗️ Migrar el repositorio a base de datos (Doctrine/MySQL o Redis)

La lógica de dominio está desacoplada. Puedes implementar cualquier repositorio siguiendo la interfaz `CartRepositoryInterface` o `OrderRepositoryInterface`.
Para usar Doctrine o Redis, simplemente cambia la implementación en `services.yaml`.



## 🛡️ Buenas prácticas y escalabilidad

* Validación y saneado de datos en cada capa
* Eventos de dominio para lógica avanzada (logs, notificaciones, etc.)
* Paginación y filtros cuando crezca el volumen
* Seguridad: añade autenticación/autorización según tus necesidades



## 🎯 Justificación técnica de arquitectura

* **Hexagonal:** dominio desacoplado del framework y de la infraestructura
* **DDD:** negocio expresivo, modelo extensible
* **CQRS:** comandos y queries separados, facilita testing y escalabilidad
* **Testabilidad:** máxima cobertura y facilidad para test unitario/integración
* **Escalabilidad:** fácil de migrar y evolucionar



## 📝 Notas adicionales

* La solución está lista para extender a multiusuario, pago real y eventos asíncronos.
* El ciclo de vida completo está cubierto por tests unitarios y de integración.
* Puedes cambiar la persistencia in-memory por cualquier tecnología real en minutos.



**Autor:** Aythami Melián Perdomo
**Fecha de desarrollo:** 06/08/2025

