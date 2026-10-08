import fs from "node:fs";
import path from "node:path";

const [, , command, bagistoRoot, mockUrl = "http://127.0.0.1:4010"] =
    process.argv;

if (!["use", "restore"].includes(command) || !bagistoRoot) {
    process.stderr.write(
        "Usage: node scripts/library-mock-portal.mjs <use|restore> <bagisto-root> [mock-url]\n",
    );
    process.exit(1);
}

const configPath = path.join(
    bagistoRoot,
    "vendor/myfatoorah/library/src/mf-config.json",
);
const backupPath = `${configPath}.e2e-backup`;

if (command === "restore") {
    if (fs.existsSync(backupPath)) {
        fs.copyFileSync(backupPath, configPath);
        fs.rmSync(backupPath);
        process.stdout.write(`Restored ${configPath}\n`);
    }

    process.exit(0);
}

if (!fs.existsSync(backupPath)) {
    fs.copyFileSync(configPath, backupPath);
}

const countries = JSON.parse(fs.readFileSync(backupPath, "utf-8"));

for (const country of Object.values(countries)) {
    country.testv2 = mockUrl;
    country.testPortal = mockUrl;
}

fs.writeFileSync(configPath, JSON.stringify(countries));

const tomorrow = new Date(Date.now() + 24 * 60 * 60 * 1000);

fs.utimesSync(configPath, tomorrow, tomorrow);

process.stdout.write(
    `Pointed the MyFatoorah library test environment at ${mockUrl}\n`,
);
