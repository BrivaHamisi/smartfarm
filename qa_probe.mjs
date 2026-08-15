export default async function run(page, ui) {
  await page.goto('http://127.0.0.1:8001/login', { waitUntil: 'domcontentloaded' });
  await page.waitForSelector('input[name="email"]', { timeout: 15000 });
  await page.fill('input[name="email"]', 'qatmp@smartfarm.test');
  await page.fill('input[name="password"]', 'password');
  await page.keyboard.press('Enter');
  await page.waitForTimeout(1500);
  await page.goto('http://127.0.0.1:8001/dashboard/admin/console', { waitUntil: 'domcontentloaded' });
  await page.waitForFunction(() => document.querySelectorAll('.console-feed').length === 3, null, { timeout: 20000 });

  const probe = () => {
    const r = getComputedStyle(document.documentElement);
    const ls = [...document.querySelectorAll('.console-entry__label')].slice(0, 8).map((l) => {
      const cs = getComputedStyle(l);
      return { label: l.textContent.trim(), color: cs.color, bg: cs.backgroundColor, strong: l.closest('.console-entry').classList.contains('console-entry--strong') };
    });
    const entry = [...document.querySelectorAll('.console-entry')].find((e) => e.dataset.tone === 'danger');
    const get = (n) => r.getPropertyValue(n).trim();
    return {
      vars: { d5: get('--danger-500'), d6: get('--danger-600'), s5: get('--success-500'), s6: get('--success-600'), g4: get('--gray-400'), g5: get('--gray-500') },
      labels: ls,
      consoleVars: entry ? { cd: getComputedStyle(entry).getPropertyValue('--console-danger').trim(), tone: getComputedStyle(entry).getPropertyValue('--tone').trim() } : null,
      isDark: document.documentElement.classList.contains('dark'),
    };
  };

  const light = await page.evaluate(probe);

  const menu = await page.evaluate(() => {
    const direct = document.querySelector('button[aria-label="Enable dark theme"]');
    if (direct) { direct.click(); return 'direct'; }
    const menuBtn = document.querySelector('.fi-user-menu button');
    if (menuBtn) { menuBtn.click(); return 'menu-opened'; }
    return 'none';
  });
  await page.waitForTimeout(500);
  await page.evaluate(() => {
    const b = document.querySelector('button[aria-label="Enable dark theme"]');
    if (b) b.click();
  });
  await page.waitForTimeout(800);
  const dark = await page.evaluate(probe);

  return { light, dark };
}
