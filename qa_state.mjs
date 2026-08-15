export default async function run(page, ui) {
  await page.goto('http://127.0.0.1:8001/login', { waitUntil: 'domcontentloaded' });
  await page.waitForSelector('input[name="email"]', { timeout: 15000 });
  await page.fill('input[name="email"]', 'qatmp@smartfarm.test');
  await page.fill('input[name="password"]', 'password');
  await page.keyboard.press('Enter');
  await page.waitForURL((url) => !url.pathname.endsWith('/login'), { timeout: 20000 }).catch(() => {});
  await page.waitForTimeout(2000);
  const afterLogin = page.url();

  await page.goto('http://127.0.0.1:8001/dashboard/admin/console', { waitUntil: 'domcontentloaded' });
  await page.waitForTimeout(5000);

  const state = await page.evaluate(() => ({
    url: location.pathname,
    title: document.title,
    bodyChars: document.body.innerText.length,
    fiWi: document.querySelectorAll('.fi-wi').length,
    feeds: document.querySelectorAll('.console-feed').length,
    entries: document.querySelectorAll('.console-entry').length,
    headings: [...document.querySelectorAll('.fi-section-header-heading')].map((h) => h.textContent.trim()),
    hasErrorBanner: !!document.querySelector('.fi-wi-error, [role="alert"]'),
    pageTitle: document.querySelector('h1')?.textContent?.trim(),
    spinner: !!document.querySelector('.animate-spin, .fi-wi-loading'),
  }));

  return { afterLogin, state };
}
