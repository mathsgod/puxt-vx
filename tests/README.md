# JWT regression tests

```sh
php8.3 vendor/bin/phpunit
```

The same tests run on PHP 8.4 and 8.5. They cover token claims and expiry,
HS256 signing, existing HS256 token decoding, malformed/expired/future/tampered
tokens, signature and algorithm rejection, refresh-page failure responses and
password-reset rejection before database access.

These tests do not connect to a database or test the full login, successful
refresh, password-reset email or WebAuthn workflows.

JWT 7 requires an HS256 secret of at least 32 bytes. The application continues
to use `VX.jwt.secret` as configured; this change does not generate or transform
the secret. Existing unexpired HS256 tokens remain valid when the same
sufficiently long secret is retained. Short legacy secrets require a separate
deployment migration; do not assume they will work with JWT 7.
