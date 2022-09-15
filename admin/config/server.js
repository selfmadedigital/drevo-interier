module.exports = ({ env }) => ({
  host: env('HOST', '0.0.0.0'),
  port: env.int('PORT', 1345),
  url: 'https://cms.drevo-interier.sk',
  admin: {
    path: '/dashboard',
    auth: {
      secret: env('ADMIN_JWT_SECRET', 'ee0b68249b7b3b6f3b326bba4cc0d3f8'),
    },
  },
});