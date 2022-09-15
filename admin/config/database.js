module.exports = ({ env }) => ({
  defaultConnection: 'default',
  connections: {
    default: {
      connector: 'bookshelf',
      settings: {
        client: 'mysql',
        host: env('DATABASE_HOST', '127.0.0.1'),
        port: env.int('DATABASE_PORT', 3306),
        database: env('DATABASE_NAME', 'drevo_interier'),
        username: env('DATABASE_USERNAME', 'drevo_interier'),
        password: env('DATABASE_PASSWORD', 'zK3StxFC9HIpH6Bw'),
        ssl: env.bool('DATABASE_SSL', false),
      },
      options: {
        strict: true
      }
    },
  },
});
