# Routing Overview

This document summarizes every first-party HTTP route defined under `routes/web.php` and `routes/auth.php`, including middleware, prefixes, and expected controllers. Use it as a quick reference when wiring new pages or debugging authorization issues.

## Public Entry Points

| Method | Path | Middleware | Action | Route name |
| --- | --- | --- | --- | --- |
| GET | `/` | – | Returns the `welcome` view. | – |

Authentication scaffolding (login, register, password reset, verification) lives in `routes/auth.php` and follows the default Laravel Breeze controllers. All of those routes are either `guest`-only (for registering/logging in) or `auth`-only (for email verification, password confirmation, logout).

## Authenticated & Verified Users

All routes below run inside the `['auth', 'verified']` middleware group.

### Generic dashboard/profile

| Method | Path | Middleware | Action | Route name |
| --- | --- | --- | --- | --- |
| GET | `/dashboard` | redirects based on role | Redirects admins to `admin.dashboard`, everyone else to `rooms.index`. | `dashboard` |
| GET | `/profile` | – | `ProfileController@edit` | `profile.edit` |
| PATCH | `/profile` | – | `ProfileController@update` | `profile.update` |
| DELETE | `/profile` | – | `ProfileController@destroy` | `profile.destroy` |

### Mahasiswa-facing (role: `mahasiswa`)

| Method | Path | Middleware | Action | Route name |
| --- | --- | --- | --- | --- |
| GET | `/rooms` | `role:mahasiswa` | `RoomController@index` (catalog with filters/search). | `rooms.index` |
| GET | `/rooms/{room}` | `role:mahasiswa` | `RoomController@show`. | `rooms.show` |
| POST | `/bookings` | `role:mahasiswa` | `BookingController@store`. | `bookings.store` |
| GET | `/my-bookings` | `role:mahasiswa` | `BookingController@index` for self history. | `my-bookings.index` |
| GET | `/bookings/{booking}/edit` | `role:mahasiswa` | `BookingController@edit`. | `bookings.edit` |
| PATCH | `/bookings/{booking}` | `role:mahasiswa` | `BookingController@update`. | `bookings.update` |
| DELETE | `/bookings/{booking}` | `role:mahasiswa` | `BookingController@destroy`. | `bookings.destroy` |

### Admin-facing (prefix `admin`, name `admin.*`, middleware `role:admin`)

| Method | Path | Action | Route name |
| --- | --- | --- | --- |
| GET | `/admin/dashboard/{year?}/{month?}` | Inline closure building the calendar view with optional month context. | `admin.dashboard` |
| GET | `/admin/bookings` | `Admin\BookingController@index` (pending + history). | `admin.bookings.index` |
| PUT | `/admin/bookings/{booking}/approve` | `Admin\BookingController@approve`. | `admin.bookings.approve` |
| PUT | `/admin/bookings/{booking}/reject` | `Admin\BookingController@reject`. | `admin.bookings.reject` |

`Route::resource('rooms', AdminRoomController::class)` expands into the standard RESTful admin room management endpoints, all under the `admin` prefix and namespace. The generated mapping is:

| Method | Path | Action | Route name |
| --- | --- | --- | --- |
| GET | `/admin/rooms` | `index` | `admin.rooms.index` |
| GET | `/admin/rooms/create` | `create` | `admin.rooms.create` |
| POST | `/admin/rooms` | `store` | `admin.rooms.store` |
| GET | `/admin/rooms/{room}` | `show` | `admin.rooms.show` |
| GET | `/admin/rooms/{room}/edit` | `edit` | `admin.rooms.edit` |
| PUT/PATCH | `/admin/rooms/{room}` | `update` | `admin.rooms.update` |
| DELETE | `/admin/rooms/{room}` | `destroy` | `admin.rooms.destroy` |

## Adding New Routes

1. Decide which audience the route serves and add it to the matching middleware group (`auth`/`verified`, `role:mahasiswa`, `role:admin`, or `guest`).
2. If the route should be guarded by role, ensure the `RoleMiddleware` recognizes that role.
3. Keep route names consistent (e.g., `admin.*` for admin namespace) so redirects like `/dashboard` continue working.
4. Document major additions here to keep the routing map in sync with the codebase.


