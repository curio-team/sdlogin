(async function scrapeData() {
    const students = [];

    while (true) {
        let nextButton = $('[id$=":next"] > a');

        if (!nextButton.length) {
            console.log('❌ No next button found! Have you navigated to the first student?');
            return;
        }

        // Scrape name and code
        let name = $('.osi-selected-item-info > span:nth(0)').text().trim();
        let code = $('.osi-selected-item-info > span:nth(1)').text().trim();

        // Scrape groups
        let groups = $('h1:contains("Groepen")')
            .next()
            .find('.osi-grid-table')
            .children()
            .find('.osi-grid-row');

        // Of each group, the first .osi-output-text is the group name, followed by a seperator ' - ' and the group description
        // The third .osi-output-text is the group type. We only want the group name and type.
        groups = groups
            .filter((i, group) => $(group).find('.osi-output-text').length > 0)
            .map((i, group) => {
                let groupInfo = $(group).find('.osi-grid-cell');
                let name = groupInfo[0].innerText;
                let type = groupInfo[2].innerText;

                // Remove everything after the first ' - ' in the group name
                name = name.split(' - ')[0];

                return { name, type };
            })
            .get();

        students.push({ name, code, groups });

        if (nextButton.attr('aria-disabled') == 'true') {
            console.log('🎊 Done!');
            break;
        }

        nextButton[0].click()

        // Wait for the page to change (detect when the name field updates)
        let oldName = name;
        await new Promise(resolve => {
            let checkChange = setInterval(() => {
                let newName = $('.osi-selected-item-info > span:nth(0)').text().trim();
                if (newName && newName !== oldName) {
                    clearInterval(checkChange);
                    resolve();
                }
            }, 15);
        });
    }

    console.log(
        JSON.stringify(students, null, 2)
    );
})();
