export default async function run(page, ui) {
  await page.goto('http://127.0.0.1:8001/login', { waitUntil: 'domcontentloaded' });
  await page.waitForSelector('input[name="email"]', { timeout: 15000 });
  await page.fill('input[name="email"]', 'qatmp@smartfarm.test');
  await page.fill('input[name="password"]', 'password');
  await page.keyboard.press('Enter');
  await page.waitForURL((url) => !url.pathname.endsWith('/login'), { timeout: 20000 }).catch(() => {});
  await page.waitForTimeout(1500);

  const timings = [];
  page.on('request', (req) => {
    if (req.url().includes('livewire')) timings.push(['req', req.url(), Date.now()]);
  });
  page.on('response', (res) => {
    if (res.url().includes('livewire')) timings.push(['res', res.url(), Date.now(), res.status()]);
  });

  const t0 = Date.now();
  await page.goto('http://127.0.0.1:8001/dashboard/admin/console', { waitUntil: 'domcontentloaded' });

  const samples = [];
  const until = Date.now() + 70000;
  while (Date.now() < until) {
    const c = await page.evaluate(() => ({ feeds: document.querySelectorAll('.console-feed').length, entries: document.querySelectorAll('.console-entry').length, spi: document.querySelectorAll('.fi-wi-loading, .animate-spin').length }));
    samples.push({ at: Date.now() - t0, ...c });
    if (c.feeds >= 3 && c.spi === 0) break;
    await page.waitForTimeout(2000);
  }

  return { samples, livewire: timings };
}
