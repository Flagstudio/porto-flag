const config = {
    moduleFileExtensions: ['js', 'ts', 'json', 'vue'],
    verbose: true,
    transform: {
        '\\.[jt]sx?$': '<rootDir>/node_modules/babel-jest',
        '^.+\\.ts?$': 'ts-jest',
        '.*\\.(vue)$': '<rootDir>/node_modules/vue3-jest',
    },
    modulePaths: ['<rootDir>/node_modules'],
};

module.exports = config;
