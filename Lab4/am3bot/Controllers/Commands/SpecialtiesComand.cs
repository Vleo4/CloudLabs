using System.Threading.Tasks;
using Telegram.Bot.Types.ReplyMarkups;
using Telegram.Bot.Types;
using Telegram.Bot;

namespace am3bot.Controllers.Commands
{
    public class SpecialtiesComand : ICommand
    {
        public TelegramBotClient Client => Bot.GetTelegramBot().Result;
        public string Name => "Спеціальності💀";

        public async Task Execute(Update update)
        {
            long chatId = update.Message.Chat.Id;

            await Client.SendTextMessageAsync(
            chatId,
            text: "(122) Компютерні науки, " +
                      "\n(121) Інженерія програмного забезпечення, " +
                      "\n(124) Системний аналіз, " +
                      "\n(125) Кібербезпека " +
                      "\n(126) Інформаційні системи та технології");
        }
    }
}
