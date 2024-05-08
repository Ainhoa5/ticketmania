# Introducción

¡Bienvenido a la documentación de TicketMania!

## Visión General
TicketMania es una API RESTful para manejar la compra de entradas a diferentes eventos como obras de teatro o musicales. Proporciona a los desarrolladores acceso a una variedad de endpoints para Mostrar, Crear, modificar y Borrar Eventos, Shows y hacer compras de entradas para dichos shows, integrando el popular servicio de Stripe para compras online.

## Propósito
El propósito de TicketMania es optimizar el proceso de gestión de ventas de entradas para eventos. Ya sea que seas un desarrollador construyendo una aplicación o un negocio integrando funcionalidades de venta de entradas, nuestra API ofrece una solución sin problemas para manejar datos relacionados con eventos.

## Autenticación
La autenticación con TicketMania se realiza mediante tokens OAuth 2.0. Los clientes que utilizen los programas de los desarrolladores pueden obtener tokens de acceso registrando su aplicación y siguiendo el flujo de autenticación para poder realizar la compra online de las entradas. A su vez, los propios desarrolladores deben registrarse de la misma forma para poder acceder a las rutas de creacion, edición y eliminacion de las entidades de la API.


# 2. Comenzando

## 2.1 Autenticación

Para autenticarte con nuestra API, sigue estos pasos:

- Para registrarte, envía una solicitud POST a `http://127.0.0.1:8000/api/register` con tu email, nombre y contraseña.
- Para iniciar sesión, envía una solicitud POST a `http://127.0.0.1:8000/api/login` con tu email y contraseña. Esto generará automáticamente un token de acceso basado en el rol de usuario (admin o no admin).
- Para cerrar sesión, simplemente realiza una solicitud POST a `http://127.0.0.1:8000/api/logout`. No es necesario enviar ningún dato, ya que el backend ya tiene la identificación del usuario que inició sesión anteriormente.

## 2.2 Ejemplos de Código

Aquí tienes un ejemplo de componente de React que realiza el inicio de sesión en la API:

```javascript
import React, { useState } from 'react';
import axios from 'axios';

const LoginForm = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');

  const handleLogin = async (event) => {
    event.preventDefault();

    try {
      const response = await axios.post('http://127.0.0.1:8000/api/login', {
        email,
        password
      });
      localStorage.setItem('token', response.data.token);
      alert('¡Inicio de sesión exitoso!');
    } catch (err) {
      setError(err.response?.data?.message || 'Fallo al iniciar sesión');
      console.error('Error de inicio de sesión:', err);
    }
  };

  return (
    <div>
      <form onSubmit={handleLogin}>
        <h2>Login</h2>
        {error && <p style={{ color: 'red' }}>{error}</p>}
        <div>
          <label htmlFor="email">Email:</label>
          <input
            type="email"
            id="email"
            value={email}
            onChange={e => setEmail(e.target.value)}
            required
          />
        </div>
        <div>
          <label htmlFor="password">Password:</label>
          <input
            type="password"
            id="password"
            value={password}
            onChange={e => setPassword(e.target.value)}
            required
          />
        </div>
        <button type="submit">Login</button>
      </form>
    </div>
  );
};

export default LoginForm; 
```

## 2.3 Estructura de los Endpoints y URL Base

La API consta de las siguientes entidades, y el acceso a cada endpoint depende del tipo de token:

- **Events**: Representa un evento. Los endpoints disponibles son GET (sin autenticación), POST, PUT y DELETE (con token si el usuario es admin).
- **Concerts**: Representa cada actuación de un evento. Los endpoints disponibles son GET (sin autenticación), POST, PUT y DELETE (con token si el usuario es admin).
- **Tickets**: Representa los tickets de cada concierto. El endpoint GET solo permite recoger los tickets del usuario autenticado, mientras que el endpoint POST se utiliza para hacer la compra del ticket (también crea una entrada en la tabla de Payments). Los permisos de acceso dependen del tipo de token.
- **Payments**: Representa uno o varios tickets de cada concierto.

La estructura base de la URL es la siguiente:

`url base` (http://127.0.0.1:8000/) + `ruta` (api) + `versión` (v1) + `entidad` (events)

Ejemplo: http://127.0.0.1:8000/api/v1/events

## 3. Endpoints

### Events

#### GET /api/v1/events
- **Descripción:** Obtiene todos los eventos disponibles.
- **Parámetros Requeridos:** Ninguno.
- **Parámetros Opcionales:** Ninguno.
- **Ejemplo de Solicitud URL:** `GET /api/v1/events`
- **Ejemplo de Respuesta:**
    - **Código de Estado:** 200 OK
    - **Cuerpo de Respuesta Ejemplo:**
        ```json
        [
            {
                "id": 1,
                "name": "Evento 1",
                "description": "Descripción del Evento 1",
                "image_cover": "https://res.cloudinary.com/daf5smpr3/image/upload/v1712153037/mxuqaznl4qzkkwnls46q.png",
                "image_background": "https://res.cloudinary.com/daf5smpr3/image/upload/v1712153037/mxuqaznl4qzkkwnls46q.png",
                "created_at": "2024-05-04T12:00:00Z",
                "updated_at": "2024-05-04T12:00:00Z"
            },
            {
                "id": 2,
                "name": "Evento 2",
                "description": "Descripción del Evento 2",
                "image_cover": "https://res.cloudinary.com/daf5smpr3/image/upload/v1712153037/mxuqaznl4qzkkwnls46q.png",
                "image_background": "https://res.cloudinary.com/daf5smpr3/image/upload/v1712153037/mxuqaznl4qzkkwnls46q.png",
                "created_at": "2024-05-04T12:00:00Z",
                "updated_at": "2024-05-04T12:00:00Z"
            }
        ]
        ```
- **Notas:** Ninguna.
#### POST /api/v1/events
- **Descripción:** Crea un nuevo evento.
- **Parámetros Requeridos:**
    - `name` (string): Nombre del evento.
    - `description` (text): Descripción del evento.
- **Parámetros Opcionales:**
    - `image_cover` (file): Imagen de portada del evento (por defecto: 'https://res.cloudinary.com/daf5smpr3/image/upload/v1712153037/mxuqaznl4qzkkwnls46q.png').
    - `image_background` (file): Imagen de fondo del evento (por defecto: 'https://res.cloudinary.com/daf5smpr3/image/upload/v1712153037/mxuqaznl4qzkkwnls46q.png').
- **Ejemplo de Solicitud URL:** `POST /api/v1/events`
- **Ejemplo de Cuerpo de Solicitud:**
    ```
    name: Nuevo Evento
    description: Descripción del Nuevo Evento
    image_cover: (archivo)
    image_background: (archivo)
    ```
- **Ejemplo de Respuesta:**
    - **Código de Estado:** 201 Created
    - **Cuerpo de Respuesta Ejemplo:**
        ```json
        {
            "id": 3,
            "name": "Nuevo Evento",
            "description": "Descripción del Nuevo Evento",
            "image_cover": "https://res.cloudinary.com/daf5smpr3/image/upload/v1712153037/mxuqaznl4qzkkwnls46q.png",
            "image_background": "https://res.cloudinary.com/daf5smpr3/image/upload/v1712153037/mxuqaznl4qzkkwnls46q.png",
            "created_at": "2024-05-04T12:00:00Z",
            "updated_at": "2024-05-04T12:00:00Z"
        }
        ```
- **Notas:** Ninguna.

#### POST /api/v1/events/{event_id}
- **Descripción:** Actualiza un evento existente. Se necesita hacer una solicitud POST para actualizar y definir el metodo por separado en uno de los campos para poder usar el tipo de dato form-data para insertar las imagenes
- **Parámetros Requeridos:**
    - `event_id` (integer): ID del evento a actualizar.
- **Parámetros Opcionales:**
    - `name` (string): Nuevo nombre del evento.
    - `description` (text): Nueva descripción del evento.
    - `image_cover` (file): Nueva imagen de portada del evento.
    - `image_background` (file): Nueva imagen de fondo del evento.
    - `_method` (text): PUT
- **Ejemplo de Solicitud URL:** `PUT /api/v1/events/1`
- **Ejemplo de Cuerpo de Solicitud:**
    ```
    name: Evento Actualizado
    description: Nueva Descripción del Evento
    image_cover: (archivo)
    image_background: (archivo)
    _method: PUT
    ```
- **Ejemplo de Respuesta:**
    - **Código de Estado:** 200 OK
    - **Cuerpo de Respuesta Ejemplo:**
        ```json
        {
            "id": 1,
            "name": "Evento Actualizado",
            "description": "Nueva Descripción del Evento",
            "image_cover": "https://res.cloudinary.com/daf5smpr3/image/upload/v1712153037/mxuqaznl4qzkkwnls46q.png",
            "image_background": "https://res.cloudinary.com/daf5smpr3/image/upload/v1712153037/mxuqaznl4qzkkwnls46q.png",
            "created_at": "2024-05-04T12:00:00Z",
            "updated_at": "2024-05-04T12:05:00Z"
        }
        ```
- **Notas:** Ninguna.

#### DELETE /api/v1/events/{event_id}
- **Descripción:** Elimina un evento existente.
- **Parámetros Requeridos:**
    - `event_id` (integer): ID del evento a eliminar.
- **Parámetros Opcionales:** Ninguno.
- **Ejemplo de Solicitud URL:** `DELETE /api/v1/events/1`
- **Ejemplo de Respuesta:**
    - **Código de Estado:** 204 No Content
    - **Cuerpo de Respuesta:** Vacío
- **Notas:** Ninguna.


### Concerts

#### GET /api/v1/concerts
- **Descripción:** Obtiene todos los conciertos disponibles.
- **Parámetros Requeridos:** Ninguno.
- **Parámetros Opcionales:** Ninguno.
- **Ejemplo de Solicitud URL:** `GET /api/v1/concerts`
- **Ejemplo de Respuesta:**
    - **Código de Estado:** 200 OK
    - **Cuerpo de Respuesta Ejemplo:**
        ```json
        [
            {
                "id": 1,
                "event_id": 1,
                "date": "2024-05-10T20:00:00Z",
                "location": "Location 1",
                "capacity_total": 1000,
                "tickets_sold": 500,
                "price": 50.00,
                "created_at": "2024-05-04T12:00:00Z",
                "updated_at": "2024-05-04T12:00:00Z"
            },
            {
                "id": 2,
                "event_id": 2,
                "date": "2024-05-12T19:00:00Z",
                "location": "Location 2",
                "capacity_total": 800,
                "tickets_sold": 400,
                "price": 40.00,
                "created_at": "2024-05-04T12:00:00Z",
                "updated_at": "2024-05-04T12:00:00Z"
            }
        ]
        ```
- **Notas:** Ninguna.

#### POST /api/v1/concerts
- **Descripción:** Crea un nuevo concierto.
- **Parámetros Requeridos:**
    - `event_id` (integer): ID del evento al que pertenece el concierto.
    - `date` (dateTime): Fecha y hora del concierto en formato ISO 8601.
    - `location` (string): Ubicación del concierto.
    - `capacity_total` (integer): Capacidad total del concierto.
    - `price` (decimal): Precio de entrada al concierto.
- **Parámetros Opcionales:**
    - Ninguno.
- **Ejemplo de Solicitud URL:** `POST /api/v1/concerts`
- **Ejemplo de Cuerpo de Solicitud:**
    ```json
    {
        "event_id": 1,
        "date": "2024-05-10T20:00:00Z",
        "location": "Location 1",
        "capacity_total": 1000,
        "price": 50.00
    }
    ```
- **Ejemplo de Respuesta:**
    - **Código de Estado:** 201 Created
    - **Cuerpo de Respuesta Ejemplo:**
        ```json
        {
            "id": 3,
            "event_id": 1,
            "date": "2024-05-10T20:00:00Z",
            "location": "Location 1",
            "capacity_total": 1000,
            "tickets_sold": 0,
            "price": 50.00,
            "created_at": "2024-05-04T12:00:00Z",
            "updated_at": "2024-05-04T12:00:00Z"
        }
        ```
- **Notas:** Ninguna.

#### PUT /api/v1/concerts/{concert_id}
- **Descripción:** Actualiza un concierto existente.
- **Parámetros Requeridos:**
    - `concert_id` (integer): ID del concierto a actualizar.
- **Parámetros Opcionales:**
    - `event_id` (integer): Nuevo ID del evento al que pertenece el concierto.
    - `date` (dateTime): Nueva fecha y hora del concierto en formato ISO 8601.
    - `location` (string): Nueva ubicación del concierto.
    - `capacity_total` (integer): Nueva capacidad total del concierto.
    - `price` (decimal): Nuevo precio de entrada al concierto.
- **Ejemplo de Solicitud URL:** `PUT /api/v1/concerts/1`
- **Ejemplo de Cuerpo de Solicitud:**
    ```json
    {
        "location": "Nueva Location",
        "capacity_total": 1200
    }
    ```
- **Ejemplo de Respuesta:**
    - **Código de Estado:** 200 OK
    - **Cuerpo de Respuesta Ejemplo:**
        ```json
        {
            "id": 1,
            "event_id": 1,
            "date": "2024-05-10T20:00:00Z",
            "location": "Nueva Location",
            "capacity_total": 1200,
            "tickets_sold": 500,
            "price": 50.00,
            "created_at": "2024-05-04T12:00:00Z",
            "updated_at": "2024-05-04T12:05:00Z"
        }
        ```
- **Notas:** Ninguna.

#### DELETE /api/v1/concerts/{concert_id}
- **Descripción:** Elimina un concierto existente.
- **Parámetros Requeridos:**
    - `concert_id` (integer): ID del concierto a eliminar.
- **Parámetros Opcionales:** Ninguno.
- **Ejemplo de Solicitud URL:** `DELETE /api/v1/concerts/1`
- **Ejemplo de Respuesta:**
    - **Código de Estado:** 204 No Content
    - **Cuerpo de Respuesta:** Vacío
- **Notas:** Ninguna.

### Tickets

#### GET /api/v1/tickets
- **Descripción:** Obtiene todos los tickets del usuario autenticado.
- **Parámetros Requeridos:** Ninguno.
- **Parámetros Opcionales:** Ninguno.
- **Ejemplo de Solicitud URL:** `GET /api/v1/tickets`
- **Ejemplo de Respuesta:**
    - **Código de Estado:** 200 OK
    - **Cuerpo de Respuesta Ejemplo:**
        ```json
        [
            {
                "id": 1,
                "concert_id": 1,
                "user_id": 1,
                "created_at": "2024-05-04T12:00:00Z",
                "updated_at": "2024-05-04T12:00:00Z"
            },
            {
                "id": 2,
                "concert_id": 2,
                "user_id": 1,
                "created_at": "2024-05-04T12:00:00Z",
                "updated_at": "2024-05-04T12:00:00Z"
            }
        ]
        ```
- **Notas:** Ninguna.
#### GET /api/v1/tickets/{ticket_id}
- **Descripción:** Obtiene un ticket específico.
- **Parámetros Requeridos:**
    - `ticket_id` (integer): ID del ticket.
- **Parámetros Opcionales:** Ninguno.
- **Ejemplo de Solicitud URL:** `GET /api/v1/tickets/1`
- **Ejemplo de Respuesta:**
    - **Código de Estado:** 200 OK
    - **Cuerpo de Respuesta Ejemplo:**
        ```json
        {
            "id": 1,
            "concert_id": 1,
            "user_id": 1,
            "created_at": "2024-05-04T12:00:00Z",
            "updated_at": "2024-05-04T12:00:00Z"
        }
        ```
- **Notas:** Ninguna.

#### POST /api/v1/tickets
- **Descripción:** Compra tickets para un concierto.
- **Parámetros Requeridos:**
    - `concertId` (integer): ID del concierto para el cual se compran los tickets.
    - `payment_method_id` (string): ID del método de pago.
- **Parámetros Opcionales:**
    - `ticketQuantity` (integer): Cantidad de tickets a comprar (por defecto: 1).
- **Ejemplo de Solicitud URL:** `POST /api/v1/tickets`
- **Ejemplo de Cuerpo de Solicitud:**
    ```json
    {
        "concertId": 1,
        "payment_method_id": "pm_123456789"
    }
    ```
- **Ejemplo de Respuesta:**
    - **Código de Estado:** 200 OK
    - **Cuerpo de Respuesta Ejemplo:**
        ```json
        {
            "tickets": [
                {
                    "id": 3,
                    "concert_id": 1,
                    "user_id": 1,
                    "created_at": "2024-05-04T12:05:00Z",
                    "updated_at": "2024-05-04T12:05:00Z"
                },
                {
                    "id": 4,
                    "concert_id": 1,
                    "user_id": 1,
                    "created_at": "2024-05-04T12:05:00Z",
                    "updated_at": "2024-05-04T12:05:00Z"
                }
            ]
        }
        ```
- **Notas:** Ninguna.

### Compra de Tickets con Stripe en React

A continuación se presenta un ejemplo de cómo realizar una compra de tickets utilizando Stripe en una aplicación React.

Este paso es necesario antes de hacer la compra de la entrada, ya que devuelve un payment_method_id, que es necesario en la solicitud POST de tickets

```jsx
import React from 'react';
import { loadStripe } from '@stripe/stripe-js';
import { Elements, CardElement, useStripe, useElements } from '@stripe/react-stripe-js';
import axios from 'axios';

// Stripe public key, replace 'pk_test_...' with your actual Stripe public key
const stripePromise = loadStripe('pk_test_51P97tcCTyXwsO44Hs2k4lfOnVxzDO1MrhCqocFqUNGqwccFOBCTMWDTICcIXWC3tbGcPkOEz9dWKIFBTal0xTQ2t00jxzOjX9O');

const cardOptions = {
    style: {
        base: {
            fontSize: '16px',
            color: '#424770',
            '::placeholder': {
                color: '#aab7c4'
            },
        },
        invalid: {
            color: '#9e2146',
        },
    }
};

const CheckoutForm = () => {
    const stripe = useStripe();
    const elements = useElements();

    const handleSubmit = async (event) => {
        event.preventDefault();

        if (!stripe || !elements) {
            // Stripe.js has not yet loaded.
            // Make sure to disable form submission until Stripe.js has loaded.
            return;
        }

        const cardElement = elements.getElement(CardElement);

        const {error, paymentMethod} = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
        });

        if (error) {
            console.log('[error]', error);
        } else {
            console.log('PaymentMethod:', paymentMethod);
            completeTicketPurchase(paymentMethod.id);
        }
    };

    const completeTicketPurchase = async (paymentMethodId) => {
        try {
            const response = await axios.post('http://127.0.0.1:8000/api/v1/tickets', {
                concertId: 1,
                payment_method_id: paymentMethodId,
                ticketQuantity: 3
            }, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`
                }
            });
            console.log('Ticket purchase successful:', response.data);
        } catch (error) {
            console.error('Error during ticket purchase:', error.response.data);
        }
    };
    

    return (
        <form onSubmit={handleSubmit}>
            <CardElement options={cardOptions} />
            <button type="submit" disabled={!stripe}>
                Buy Ticket
            </button>
        </form>
    );
};

const TicketPurchase = () => (
    <Elements stripe={stripePromise}>
        <CheckoutForm />
    </Elements>
);

export default TicketPurchase;
```
